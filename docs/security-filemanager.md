# Security change notes

## Unreleased: file-manager authentication hardening (draft PR #4, 2026-11-14)

**Status:** Proposed and awaiting integration/security testing. Not yet deployed or merged.

### Issue
The RichFilemanager API route in `src/routes/api.php` accepted GET/POST requests without a session-authentication requirement, and its authentication and read/write authorization callbacks unconditionally allowed operations.

### Changes
- Require the existing Laravel `web` (session and CSRF) and `auth` middleware on the file-manager route.
- Replace unconditional callback success with a check that the requester has an authenticated session.
- Preserve the current storage path and supported extension configuration to minimize unrelated behavior changes.

### Verification before merge
- Confirm unauthenticated GET/POST file-manager requests are rejected.
- Confirm authenticated users can browse, upload, rename, delete and download through the file-manager UI as intended.
- Confirm authenticated POST requests include CSRF tokens. Update the frontend connector configuration if needed.
- Confirm file paths are limited to the intended storage root and that direct PHP connector paths cannot bypass the protected Laravel route.
- Check that *any authenticated user* is actually authorized to access the file manager. Replace the basic `auth()->check()` checks with explicit roles/policies if required.
- Run PHP lint, application tests and a dependency vulnerability scan in a supported PHP environment.
- Review server logs for any unexpected unauthenticated file operations; assess exposure according to the deployment history.

### Rollout and rollback
Deploy after tests on staging, monitor authorization failures and file manager operations, and revert this change if the integration breaks. Do not disable authorization as a workaround.

### Outstanding security debt
The project depends on legacy Laravel 5.6 and other older PHP libraries. This targeted patch does not resolve dependency CVEs or validate production configuration. Plan a separately tested upgrade and audit.

No public vulnerability identifier is asserted for this custom application issue.
