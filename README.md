# True Compliance API - Tech Test Submission

This is my submission for the True Compliance technical test, built with Laravel 12.

The API fulfills all the requirements specified in the brief, providing RESTful endpoints for managing properties, certificates, and their associated notes, all backed by a MySQL database.

---

## 1. The Original Task

1.  Using Laravel, MySQL and the enclosed data create an API that serves data to the following endpoints:

    `GET /property` - Returns properties
    `GET /property/{id}` - Returns a property
    `POST /property` - Creates a new property
    `PATCH /property/{id}` - Updates a property
    `DELETE /property/{id}` - Deletes a property
    `GET /property/{id}/certificate` - Returns the certificates of a property
    `GET /property/{id}/note` - Returns the notes of a property
    `POST /property/{id}/note` - Creates a note for a property

    `GET /certificate` - Returns certificates
    `GET /certificate/{id}` - Returns a certificate
    `POST /certificate` - Creates a certificate
    `GET /certificate/{id}/note` - Returns the notes of a certificate
    `POST /certificate/{id}/note` - Creates a note for a certificate

2.  Write a MySQL raw query & eloquent query to get properties which has more than 5 certificates.

---

## 2. Setup & Installation

### Prerequisites
* **PHP >= 8.2**
* **Composer**
* **MySQL**

### Step-by-Step Setup

1.  **Clone the Repository:**
    ```bash
    git clone https://github.com/Timmsy1998/true-compliance-api.git
    cd true-compliance-api
    ```

2.  **Install Dependencies:**
    ```bash
    composer install
    ```

3.  **Create an empty MySQL database** (e.g., `true_compliance_test`).

4.  **Create `.env` File:**
    Copy the example environment file and fill in your database details.
    ```bash
    cp .env.example .env
    ```

5.  **Edit `.env`:**
    Update the `DB_` variables to match your MySQL setup
    ```ini
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=true_compliance_test
    DB_USERNAME=root
    DB_PASSWORD=password

    # It's also recommended to set the session driver to 'file'
    SESSION_DRIVER=file
    ```

6.  **Generate App Key:**
    ```bash
    php artisan key:generate
    ```

7.  **Run Database Migrations:**
    This will build the schema (`properties`, `certificates`, `notes`, etc.).
    ```bash
    php artisan migrate:fresh
    ```

8.  **Import Data:**
    Import the provided `datadump.sql` file (which should be placed in `database/dump/`).
    ```bash
    mysql -u [your_db_user] -p [your_db_name] < database/dump/datadump.sql
    ```

9.  **Clear Caches:**
    ```bash
    php artisan route:clear
    php artisan config:clear
    ```

---

## 3. Running the Project

1.  **Start The Local Development Server**
    ```bash
    php artisan serve
    ```

2.  **Access the API:**
    The API will now be running at `http://127.0.0.1:8000`.  
    All API Endpoints are prefixed with `/api`.  
    **Example:** `http://127.0.0.1:8000/api/property`
---

## 4. API Endpoints

All endpoints are prefixed with `/api`.

### Property
| Method | URL | Action |
| --- | --- | --- |
| `GET` | `/property` | Returns all properties. |
| `POST` | `/property` | Creates a new property. |
| `GET` | `/property/{id}` | Returns a single property. |
| `PATCH` | `/property/{id}` | Updates a property. |
| `DELETE` | `/property/{id}` | Deletes a property. |
| `GET` | `/property/{id}/certificate` | Returns a property's certificates. |
| `GET` | `/property/{id}/note` | Returns a property's notes. |
| `POST` | `/property/{id}/note` | Creates a new note for a property. |

### Certificate
| Method | URL | Action |
| --- | --- | --- |
| `GET` | `/certificate` | Returns all certificates. |
| `POST` | `/certificate` | Creates a new certificate. |
| `GET` | `/certificate/{id}` | Returns a single certificate. |
| `GET` | `/certificate/{id}/note` | Returns a certificate's notes. |
| `POST` | `/certificate/{id}/note` | Creates a new note for a certificate. |

---

## 5. Solution to Task 2

**Query to get properties which has more than 5 certificates:**

### Eloquent Query
```php
use App\Models\Property;

$properties = Property::withCount('certificates')
                      ->having('certificates_count', '>', 5)
                      ->get();
```

### Raw MySQL Query
```sql
SELECT
  properties.*,
  COUNT(certificates.id) AS certificates_count
FROM
  properties
JOIN
  certificates ON properties.id = certificates.property_id
GROUP BY
  properties.id
HAVING
  certificates_count > 5;
```

---

## 6. Design Notes

* **Polymorphic Relationship:** 
    A polymorphic relationship (`morphMany`/`morphTo`) was used for the `notes` table. This allows both `Property` and `Certificate` models to have notes using a single `notes` table, which is clean and scalable.

* **Routing:**
    The API routes in `routes/api.php` were defined manually (e.g., `Route::get('/property', ...)` ) instead of using `apiResource` to ensure the URLs *exactly* match the tech test's singular (`/property`) requirement.

* **Validation:**
    Validation rules have been added to the `store` and `update` methods in both controllers to ensure data integrity.

* **Soft Deletes:**
    `SoftDeletes` have been implemented on the `Property` and `Certificate` models to handle the `deleted_at` column in the data.


---

## 7. Statistics

* **Date & Time Started:**
    `12/11/2025 19:30`

* **Date & Time Finished:**
    `12/11/2025 20:45`

* **Time Taken:**
    `75 minutes` / `1 hour 15 minutes`
