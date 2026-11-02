---
name: auth-account
description: "Analyze, implement, review, and test login, logout, user-account management, role checks, and session access in this PHP MVC exam system. Use when changing AuthController, Auth, Controller authorization helpers, TaikhoanController, User_m, student login, or account permissions."
---

# Authentication and Account Management

## Purpose and Scope

Use this skill for authentication and authorization workflows in `Nhom5_DAXDVPTPM_UTT`, including:

- Staff account login and logout.
- Student login.
- User account administration, including create, edit, delete, search, pagination, and CSV import.
- Role checks and session-protected controller actions.
- Bugs involving disabled accounts, redirects, or access to protected pages.

Do not treat student records and staff accounts as the same entity. Exam-room behavior, exam-taking, student/class administration, and unrelated modules are outside scope unless the request directly involves authentication or account permissions.

## Project-Specific Structure

Inspect the current repository before assuming a route, method, or schema:

- `Core/App.php` parses `index.php?url=Controller/action/...` and starts the session.
- `Core/Controller.php` provides `needLogin()`, `needAdmin()`, `needGV()`, and `needHV()`.
- `Core/Auth.php` provides static session helpers used by parts of the application.
- `MVC/Controllers/AuthController.php` handles login and logout.
- `MVC/Controllers/TaikhoanController.php` manages staff/user accounts.
- `MVC/Models/User_m.php` accesses the `users` table.
- `MVC/Models/Hocvien_m.php` looks up student accounts in `hoc_vien`.
- `MVC/Views/Pages/login.php` renders the login form.

The current login flow uses separate session records:

- Staff accounts are stored in `$_SESSION["user"]`. Their `role` is used for access checks. Existing roles include `admin` and `gv`.
- Student accounts are stored in `$_SESSION["hv"]` and are looked up by `ma_hv`; they do not use the staff `users` table.
- Staff accounts are redirected according to role; students are redirected to the student exam-room flow.
- Account status is represented by `trangthai`.
- New staff passwords are created with `password_hash(..., PASSWORD_BCRYPT)`. The current login flow also contains legacy plaintext password compatibility. Do not silently change this migration-sensitive behavior; explain and test any requested change.

These are observations of the current code, not guarantees that future schema or routes remain unchanged. Verify the schema and call sites before editing.

## Required Workflow

1. Check `git status` and the current branch; preserve all existing user changes.
2. Read the relevant controller, model, route dispatch, access helper, view, and database schema.
3. Trace the full path: login form → controller action → model lookup → session assignment → redirect; for protected actions, trace the route to its authorization guard.
4. Decide whether the operation concerns a staff account (`users`) or a student record (`hoc_vien`). Do not mix their IDs, credentials, or session keys.
5. Make the smallest change that enforces the requested behavior server-side. Do not rely on hiding links or buttons in views as authorization.
6. Review every related action, including create/update/delete/import/export/template endpoints, so access policy is consistent.
7. Run focused checks or tests available in the repository. State clearly what was and was not tested.

## Implementation and Safety Rules

- Follow the existing PHP MVC structure and route conventions.
- Protect every privileged controller action with the appropriate server-side guard. Use `needAdmin()` for administrator-only account administration; use other roles only where the existing business rules require them.
- Do not assume a submitted role is valid or authorized. Inspect the role options and existing policy before changing role assignment behavior.
- Validate identifiers, required fields, status values, and account ownership on the server.
- Keep SQL parameterized; follow the existing model/database access pattern.
- Escape user-controlled values when rendering HTML.
- Preserve the distinct `user` and `hv` session contexts and their logout/redirect behavior unless the task explicitly changes them.
- Never log, print, commit, or expose passwords, session IDs, secrets, or real account data.
- Do not introduce password-reset, lockout, CSRF, session-regeneration, or role features unless requested and compatible with the project.
- Do not change the schema, shared `Core/` behavior, or another module's files without confirming the need and scope.
- Surface failures using the project's established error/flash/redirect conventions; do not report success when the model operation failed.

## Focused Verification Checklist

Verify applicable cases using safe test accounts and a non-production database:

1. Valid staff credentials establish the staff session and follow the expected role redirect.
2. Valid student credentials establish only the student session and reach the student flow.
3. Invalid credentials and disabled accounts are rejected without exposing which credential was wrong.
4. Anonymous requests to protected actions are redirected to login.
5. A non-admin staff account cannot access administrator-only account actions, including direct URLs and mutation endpoints.
6. An administrator can perform allowed account operations; invalid or duplicate input is rejected with a clear message.
7. Deleting the currently logged-in account is handled according to the existing safeguard.
8. Logout clears the expected session and protected pages cannot be revisited with the old session.
9. Password storage and legacy credential behavior remain compatible with the requested change.

Do not claim security or functional coverage beyond the cases actually exercised.

## Response Format

Respond in Vietnamese unless the user requests another language. Summarize:

- The authentication/account behavior changed.
- Files affected and why.
- Authorization and credential-handling implications.
- Tests run and their actual results.
- Any unresolved risks or required manual verification.
