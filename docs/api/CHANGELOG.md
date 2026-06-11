# API Changelog

All notable changes to the WebMin REST API layer will be documented in this file.

---

## [1.0.0] - 2026-06-11

### Added
* Standardized REST API endpoints under `/api/v1/` prefix.
* Added `GET /units` & `GET /units/{slug}` endpoints for school list and details.
* Added `GET /units/{slug}/news` & `GET /units/{slug}/news/{newsSlug}` endpoints for paginated unit news.
* Added `GET /units/{slug}/achievements` with recipient (`siswa|guru|tendik|sekolah`) filtering.
* Added `GET /units/{slug}/extracurriculars` for extracurricular activities.
* Added `GET /units/{slug}/galleries` with placement filtering and `GET /units/{slug}/galleries/{id}` for multi-photo list sorted by order.
* Added `GET /units/{slug}/spmb` for admission guidelines and status.
* Added `GET /units/{slug}/majors` & `GET /units/{slug}/majors/{id}` (exclusive for SMK units, returning 404 for other jenjangs).
* Integrated **CORS** support and global **Rate Limiting** of 60 requests per minute per IP.
* Configured automated API documentation generation via **Scribe** (served dynamically at `/docs`).
* Generated Postman Collection and OpenAPI Specification v3 assets in the repository.
