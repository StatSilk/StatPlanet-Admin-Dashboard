# Security Policy

This repository contains a legacy Laravel application. Published dependency versions may have known vulnerabilities and should not be assumed secure for internet-facing deployment.

## Reporting a vulnerability

Please use GitHub's **Report a vulnerability** / private vulnerability reporting feature if it is available for this repository. Otherwise contact the repository owner through an established private channel. Avoid disclosing exploitation details publicly before remediation.

## Supported versions

Security support is not guaranteed for the historical Laravel 5.6 codebase. Security changes should be tested in a staging environment before deployment.

## Security maintenance

Review open dependency alerts, update supported libraries, and check access controls, CSRF handling, file uploads, storage permissions, and direct-access routes. See [security change notes](docs/security-filemanager.md) for the current proposed authentication hardening.
