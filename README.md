# Laravel API Documentation

## Authentication

### Register
POST /api/register

**Body (JSON):**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "secret123"
}


Success Response (201):

{
  "message": "Registration successful",
  "token": "1|abc123..."
}


Validation Error (422):

{
  "success": false,
  "errors": {
    "email": ["The email has already been taken."]
  }
}

Login
POST /api/login


Body (JSON):

{
  "email": "john@example.com",
  "password": "secret123"
}


Success Response (200):

{
  "message": "Login successful",
  "token": "1|abc123..."
}


Invalid Credentials (401):

{
  "message": "Invalid credentials"
}

URL Shortener (Authenticated)
Shorten URL
POST /api/shorten


Headers:

Authorization: Bearer YOUR_TOKEN
Accept: application/json


Body (JSON):

{
  "url": "https://www.facebook.com"
}


Success Response (201):

{
  "success": true,
  "short_url": "http://yourdomain.com/api/Ab3XyZ"
}


Validation Error (422):

{
  "success": false,
  "errors": {
    "url": ["The url has already been taken."]
  }
}


Unauthorized (401):

{
  "message": "Unauthenticated."
}
