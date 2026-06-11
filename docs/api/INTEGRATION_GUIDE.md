# REST API Integration Guide

Welcome to the WebMin School CMS REST API integration guide. This document explains how to consume the school data from your frontend applications (e.g. Next.js, React Native, Vue, etc.).

---

## 🚀 Base URL & Versioning

The API versioning is structured under the `/api/v1/` prefix.

* **Local Environment**: `http://localhost/api/v1`
* **Production Environment**: `https://cms.yourdomain.com/api/v1`

---

## 🚦 Rate Limiting & Headers

All endpoints enforce a global rate limit to protect system performance:

* **Limit**: Maximum **60 requests per minute** per client IP.
* **Response Headers**:
  * `X-RateLimit-Limit`: The maximum number of allowed requests (60).
  * `X-RateLimit-Remaining`: The number of requests left for the current time window.
  * `Retry-After`: The number of seconds to wait before making a new request if rate limited (returns HTTP `429 Too Many Requests`).

---

## 📦 API Response Wrapper

Every API response follows a unified JSON format:

### Success Response Example
```json
{
    "success": true,
    "message": "Daftar unit sekolah berhasil diambil.",
    "data": []
}
```

### Error Response Example (e.g., 404 Not Found)
```json
{
    "success": false,
    "message": "Record not found.",
    "data": null
}
```

---

## 🗺️ Display Placement Routing (`opsi_tampilan`)

For unit galleries (`GET /api/v1/units/{slug}/galleries`), the `opsi_tampilan` parameter dictates where the media should render on the frontend:

1. **`hero_section`**: Top slider/banner on the homepage.
2. **`gambar_pembuka`**: A single intro/welcoming image.
3. **`galeri_dokumentasi`**: General school documentation albums.
4. **`galeri_program`**: Major-specific portfolios/program galleries (linked to `major_id`).

---

## 🔧 Major (Jurusan) Conditional

* The `/majors` endpoints are **SMK-only** features.
* Accessing `/majors` or `/majors/{id}` on TK or SMP units will return a `404 Not Found` response.
* In the `/majors` output, the `galeri_program` array lists galleries related to that specific competency.

---

## 📄 Pagination Format (News Listing)

The `/news` list utilizes standard paginated responses.

```json
{
    "success": true,
    "message": "Daftar berita berhasil diambil.",
    "data": [
        {
            "id": 1,
            "judul_berita": "...",
            "slug": "...",
            "konten_berita": "...",
            "gambar_utama": "...",
            "published_at": "..."
        }
    ],
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 2,
        "path": "http://localhost/api/v1/units/smk-mandiri/news",
        "per_page": 10,
        "to": 10,
        "total": 12
    },
    "links": {
        "first": "http://localhost/api/v1/units/smk-mandiri/news?page=1",
        "last": "http://localhost/api/v1/units/smk-mandiri/news?page=2",
        "prev": null,
        "next": "http://localhost/api/v1/units/smk-mandiri/news?page=2"
    }
}
```
Use `?per_page=N` and `?page=M` query parameters to navigate results.
