# 📡 SIRAGA API Documentation

RESTful API Documentation for SIRAGA Mobile Integration

---

## 📋 Table of Contents

- [Overview](#overview)
- [Base URL](#base-url)
- [Authentication](#authentication)
- [Common Response Formats](#common-response-formats)
- [Endpoints](#endpoints)
  - [Authentication](#authentication-endpoints)
  - [Children](#children-endpoints)
  - [Measurements](#measurements-endpoints)
  - [Immunizations](#immunizations-endpoints)
  - [Statistics](#statistics-endpoints)
  - [Notifications](#notifications-endpoints)
- [Error Handling](#error-handling)
- [Rate Limiting](#rate-limiting)
- [Examples](#examples)

---

## Overview

SIRAGA API menggunakan arsitektur RESTful dengan format JSON untuk request dan response. API ini didesain untuk integrasi dengan aplikasi mobile dan third-party applications.

### Features
- ✅ JWT Authentication
- ✅ JSON Request/Response
- ✅ Rate Limiting
- ✅ Error Handling
- ✅ CORS Support
- ✅ API Versioning

---

## Base URL

```
Development: http://localhost/siraga/api
Production: https://api.siraga.com
```

### API Version
Current version: **v1**

All endpoints are prefixed with `/api`:
```
http://localhost/siraga/api/{endpoint}
```

---

## Authentication

SIRAGA API menggunakan JWT (JSON Web Token) untuk autentikasi.

### Getting Token

**POST** `/api/auth/login`

Request:
```json
{
  "email": "user@example.com",
  "password": "password123"
}
```

Response:
```json
{
  "success": true,
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
  "token_type": "Bearer",
  "expires_in": 86400,
  "user": {
    "id": 1,
    "email": "user@example.com",
    "full_name": "John Doe",
    "role": "parent",
    "profile_image": null
  }
}
```

### Using Token

Include token in Authorization header for all protected endpoints:

```http
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...
```

Example:
```bash
curl -H "Authorization: Bearer YOUR_TOKEN_HERE" \
     https://api.siraga.com/children
```

### Token Expiration

- Default expiration: **24 hours** (86400 seconds)
- Use refresh token endpoint to get new token before expiration

**POST** `/api/auth/refresh`

Request Header:
```http
Authorization: Bearer OLD_TOKEN
```

Response:
```json
{
  "success": true,
  "token": "NEW_TOKEN_HERE",
  "expires_in": 86400
}
```

---

## Common Response Formats

### Success Response

```json
{
  "success": true,
  "data": {
    // Response data here
  },
  "message": "Success message (optional)"
}
```

### Paginated Response

```json
{
  "success": true,
  "data": [...],
  "pagination": {
    "current_page": 1,
    "per_page": 10,
    "total": 50,
    "last_page": 5,
    "from": 1,
    "to": 10
  }
}
```

### Error Response

```json
{
  "success": false,
  "message": "Error message",
  "errors": {
    "field_name": ["Error detail"]
  }
}
```

---

## Endpoints

### Authentication Endpoints

#### 1. Login

**POST** `/api/auth/login`

Request Body:
```json
{
  "email": "user@example.com",
  "password": "password123"
}
```

Response: `200 OK`
```json
{
  "success": true,
  "token": "JWT_TOKEN",
  "user": {...}
}
```

#### 2. Register

**POST** `/api/auth/register`

Request Body:
```json
{
  "full_name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "phone": "081234567890",
  "role": "parent"
}
```

Response: `201 Created`
```json
{
  "success": true,
  "message": "Registration successful",
  "user": {...}
}
```

#### 3. Get Current User

**GET** `/api/auth/me`

Headers:
```http
Authorization: Bearer JWT_TOKEN
```

Response: `200 OK`
```json
{
  "success": true,
  "data": {
    "id": 1,
    "email": "user@example.com",
    "full_name": "John Doe",
    "phone": "081234567890",
    "role": "parent",
    "profile_image": "url_to_image",
    "created_at": "2024-01-01 10:00:00"
  }
}
```

#### 4. Refresh Token

**POST** `/api/auth/refresh`

Headers:
```http
Authorization: Bearer OLD_TOKEN
```

Response: `200 OK`
```json
{
  "success": true,
  "token": "NEW_JWT_TOKEN",
  "expires_in": 86400
}
```

---

### Children Endpoints

#### 1. Get All Children

**GET** `/api/children`

Query Parameters:
- `page` (optional): Page number, default: 1
- `limit` (optional): Items per page, default: 10
- `search` (optional): Search by name or NIK
- `gender` (optional): Filter by gender (male/female)

Example:
```
GET /api/children?page=1&limit=10&search=john&gender=male
```

Response: `200 OK`
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "parent_id": 1,
      "full_name": "Jane Doe",
      "nickname": "Jane",
      "nik": "3201234567890123",
      "birth_date": "2020-01-15",
      "birth_place": "Jakarta",
      "gender": "female",
      "blood_type": "A",
      "birth_weight": 3.2,
      "birth_height": 50,
      "birth_head_circumference": 35,
      "address": "Jl. Example No. 123",
      "city": "Jakarta",
      "province": "DKI Jakarta",
      "photo": "url_to_photo",
      "created_at": "2024-01-01 10:00:00"
    }
  ],
  "pagination": {...}
}
```

#### 2. Get Child by ID

**GET** `/api/children/{id}`

Response: `200 OK`
```json
{
  "success": true,
  "data": {
    "id": 1,
    "full_name": "Jane Doe",
    ...
  }
}
```

#### 3. Create New Child

**POST** `/api/children`

Request Body:
```json
{
  "full_name": "Jane Doe",
  "nickname": "Jane",
  "nik": "3201234567890123",
  "birth_date": "2020-01-15",
  "birth_place": "Jakarta",
  "gender": "female",
  "blood_type": "A",
  "birth_weight": 3.2,
  "birth_height": 50,
  "birth_head_circumference": 35,
  "address": "Jl. Example No. 123",
  "city": "Jakarta",
  "province": "DKI Jakarta"
}
```

Response: `201 Created`
```json
{
  "success": true,
  "message": "Child created successfully",
  "data": {...}
}
```

#### 4. Update Child

**PUT** `/api/children/{id}`

Request Body: (same as create, all fields optional)
```json
{
  "full_name": "Jane Updated",
  "nickname": "Janie"
}
```

Response: `200 OK`
```json
{
  "success": true,
  "message": "Child updated successfully",
  "data": {...}
}
```

#### 5. Delete Child

**DELETE** `/api/children/{id}`

Response: `200 OK`
```json
{
  "success": true,
  "message": "Child deleted successfully"
}
```

---

### Measurements Endpoints

#### 1. Get All Measurements

**GET** `/api/measurements`

Query Parameters:
- `child_id` (optional): Filter by child
- `page`, `limit`: Pagination

Response: `200 OK`
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "child_id": 1,
      "measurement_date": "2024-01-15",
      "age_months": 12,
      "weight": 10.5,
      "height": 75,
      "head_circumference": 45,
      "arm_circumference": 15,
      "body_temperature": 36.5,
      "bmi": 18.67,
      "weight_for_age_status": "normal",
      "height_for_age_status": "normal",
      "measured_by": 2,
      "measured_by_name": "Dr. Smith",
      "created_at": "2024-01-15 10:00:00"
    }
  ],
  "pagination": {...}
}
```

#### 2. Get Measurements by Child

**GET** `/api/children/{id}/measurements`

Response: `200 OK`
```json
{
  "success": true,
  "data": [...]
}
```

#### 3. Create Measurement

**POST** `/api/measurements`

Request Body:
```json
{
  "child_id": 1,
  "measurement_date": "2024-01-15",
  "age_months": 12,
  "weight": 10.5,
  "height": 75,
  "head_circumference": 45,
  "arm_circumference": 15,
  "body_temperature": 36.5,
  "notes": "Child is healthy"
}
```

Response: `201 Created`
```json
{
  "success": true,
  "message": "Measurement created successfully",
  "data": {...}
}
```

#### 4. Update Measurement

**PUT** `/api/measurements/{id}`

Request Body: (same as create, fields optional)

Response: `200 OK`

---

### Immunizations Endpoints

#### 1. Get All Immunizations

**GET** `/api/immunizations`

Query Parameters:
- `child_id` (optional)
- `status` (optional): scheduled/completed/missed
- `page`, `limit`

Response: `200 OK`
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "child_id": 1,
      "vaccine_name": "BCG",
      "vaccine_type": "BCG",
      "dose_number": 1,
      "scheduled_date": "2020-02-15",
      "immunization_date": "2020-02-15",
      "status": "completed",
      "location": "Puskesmas XYZ",
      "batch_number": "ABC123",
      "immunized_by": 2,
      "immunized_by_name": "Dr. Smith"
    }
  ]
}
```

#### 2. Get Immunizations by Child

**GET** `/api/children/{id}/immunizations`

Response: `200 OK`

#### 3. Create Immunization Schedule

**POST** `/api/immunizations`

Request Body:
```json
{
  "child_id": 1,
  "vaccine_name": "DPT 1",
  "vaccine_type": "DPT",
  "dose_number": 1,
  "scheduled_date": "2020-03-15"
}
```

Response: `201 Created`

#### 4. Mark Immunization as Completed

**PATCH** `/api/immunizations/{id}/complete`

Request Body:
```json
{
  "immunization_date": "2020-03-15",
  "location": "Puskesmas XYZ",
  "batch_number": "ABC123",
  "manufacturer": "Bio Farma",
  "site": "Left thigh",
  "reaction": "No reaction",
  "notes": "Child was calm during injection"
}
```

Response: `200 OK`
```json
{
  "success": true,
  "message": "Immunization marked as completed",
  "data": {...}
}
```

---

### Statistics Endpoints

**Note:** Accessible only for `nakes` and `government` roles

#### 1. Get Overview Statistics

**GET** `/api/statistics/overview`

Response: `200 OK`
```json
{
  "success": true,
  "data": {
    "total_children": 1000,
    "total_measurements": 5000,
    "total_immunizations": 3000,
    "immunization_coverage": 95.5,
    "active_parents": 500,
    "active_nakes": 50
  }
}
```

#### 2. Get Children Statistics

**GET** `/api/statistics/children`

Response: `200 OK`
```json
{
  "success": true,
  "data": {
    "total_children": 1000,
    "male_count": 520,
    "female_count": 480,
    "avg_age_months": 24,
    "by_province": [...]
  }
}
```

#### 3. Get Measurements Statistics

**GET** `/api/statistics/measurements`

Response: `200 OK`
```json
{
  "success": true,
  "data": {
    "total_measurements": 5000,
    "avg_weight": 12.5,
    "avg_height": 80.5,
    "underweight_count": 50,
    "stunted_count": 30,
    "wasted_count": 20,
    "nutritional_status_distribution": [...]
  }
}
```

#### 4. Get Immunizations Statistics

**GET** `/api/statistics/immunizations`

Response: `200 OK`
```json
{
  "success": true,
  "data": {
    "total_immunizations": 3000,
    "completed": 2500,
    "scheduled": 400,
    "missed": 100,
    "coverage_by_vaccine": [...]
  }
}
```

---

### Notifications Endpoints

#### 1. Get All Notifications

**GET** `/api/notifications`

Query Parameters:
- `is_read` (optional): 0 or 1
- `page`, `limit`

Response: `200 OK`
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "type": "immunization_reminder",
      "title": "Pengingat Imunisasi",
      "message": "Jadwal imunisasi DPT 2 untuk Jane besok",
      "link": "/immunizations/5",
      "is_read": 0,
      "created_at": "2024-01-14 10:00:00"
    }
  ]
}
```

#### 2. Mark Notification as Read

**PATCH** `/api/notifications/{id}/read`

Response: `200 OK`
```json
{
  "success": true,
  "message": "Notification marked as read"
}
```

---

## Error Handling

### HTTP Status Codes

- `200` - OK: Request successful
- `201` - Created: Resource created successfully
- `400` - Bad Request: Invalid input
- `401` - Unauthorized: Invalid/missing token
- `403` - Forbidden: Insufficient permissions
- `404` - Not Found: Resource not found
- `422` - Unprocessable Entity: Validation failed
- `429` - Too Many Requests: Rate limit exceeded
- `500` - Internal Server Error: Server error

### Error Response Format

```json
{
  "success": false,
  "message": "Error message",
  "errors": {
    "field_name": [
      "Validation error message"
    ]
  },
  "code": 400
}
```

### Common Errors

#### 401 Unauthorized
```json
{
  "success": false,
  "message": "Unauthorized. Please login first.",
  "code": 401
}
```

#### 403 Forbidden
```json
{
  "success": false,
  "message": "Forbidden. You do not have permission to access this resource.",
  "code": 403
}
```

#### 404 Not Found
```json
{
  "success": false,
  "message": "Resource not found",
  "code": 404
}
```

#### 422 Validation Error
```json
{
  "success": false,
  "message": "Validation failed",
  "errors": {
    "email": ["Email is required"],
    "password": ["Password must be at least 6 characters"]
  },
  "code": 422
}
```

---

## Rate Limiting

API requests are rate limited to prevent abuse:

- **Authenticated requests**: 1000 requests per hour
- **Unauthenticated requests**: 100 requests per hour

Rate limit headers are included in responses:
```http
X-RateLimit-Limit: 1000
X-RateLimit-Remaining: 999
X-RateLimit-Reset: 1640995200
```

When rate limit is exceeded:
```json
{
  "success": false,
  "message": "Rate limit exceeded. Please try again later.",
  "code": 429
}
```

---

## Examples

### Complete Workflow Example

#### 1. Register New User
```bash
curl -X POST http://localhost/siraga/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "full_name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "phone": "081234567890",
    "role": "parent"
  }'
```

#### 2. Login and Get Token
```bash
curl -X POST http://localhost/siraga/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "john@example.com",
    "password": "password123"
  }'
```

Save the token from response.

#### 3. Add Child
```bash
curl -X POST http://localhost/siraga/api/children \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -d '{
    "full_name": "Jane Doe",
    "birth_date": "2020-01-15",
    "gender": "female",
    "birth_weight": 3.2,
    "birth_height": 50
  }'
```

#### 4. Get Children
```bash
curl -X GET http://localhost/siraga/api/children \
  -H "Authorization: Bearer YOUR_TOKEN"
```

#### 5. Add Measurement
```bash
curl -X POST http://localhost/siraga/api/measurements \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -d '{
    "child_id": 1,
    "measurement_date": "2024-01-15",
    "age_months": 12,
    "weight": 10.5,
    "height": 75,
    "head_circumference": 45
  }'
```

### JavaScript/Fetch Example

```javascript
// Login
const login = async () => {
  const response = await fetch('http://localhost/siraga/api/auth/login', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      email: 'john@example.com',
      password: 'password123'
    })
  });
  
  const data = await response.json();
  localStorage.setItem('token', data.token);
  return data;
};

// Get Children
const getChildren = async () => {
  const token = localStorage.getItem('token');
  
  const response = await fetch('http://localhost/siraga/api/children', {
    headers: {
      'Authorization': `Bearer ${token}`
    }
  });
  
  const data = await response.json();
  return data.data;
};

// Create Child
const createChild = async (childData) => {
  const token = localStorage.getItem('token');
  
  const response = await fetch('http://localhost/siraga/api/children', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Authorization': `Bearer ${token}`
    },
    body: JSON.stringify(childData)
  });
  
  return await response.json();
};
```

---

## Support

Untuk bantuan lebih lanjut:

- 📧 Email: api-support@siraga.com
- 📖 Documentation: https://docs.siraga.com
- 🐛 Report Issues: https://github.com/yourusername/siraga/issues

---

**Last Updated:** 2024-01-15  
**API Version:** 1.0.0
