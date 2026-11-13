# Changelog

## Unreleased

### Security (proposed, not deployed)
- Add authenticated-session and web/CSRF middleware requirements for the RichFilemanager API route.
- Replace permissive file-manager authentication and read/write callbacks with authenticated-user checks.
- Document testing, deployment and outstanding authorization/dependency risks in [security change notes](docs/security-filemanager.md).

**Status:** Draft pull request #4. Do not regard this as deployed, independently security-audited or an upgrade of the legacy Laravel dependencies.
