# Security Policy

## Supported Versions

| Version | Supported          |
| ------- | ------------------ |
| 1.0.x   | :white_check_mark: |
| < 1.0   | :x:                |

## Reporting a Vulnerability

Please **DO NOT** report security vulnerabilities publicly.

Instead, please email **security@localzet.com** with:
- Description of the vulnerability
- Steps to reproduce
- Potential impact
- Suggested fix (if any)

We will acknowledge receipt within 24 hours and provide an initial response within 48 hours.

## Security Best Practices

1. Always keep dependencies up to date
2. Use HTTPS in production
3. Set `debug = false` in production
4. Use parameterized queries for database operations
5. Validate and sanitize all user input
6. Use CSRF protection for state-changing operations
7. Configure CORS properly for your domain
8. Use secure session configuration
9. Implement rate limiting for public APIs
10. Regular security audits of your application code

## Disclosure Policy

- We will investigate and respond to all security reports
- We will notify affected users if a vulnerability is confirmed
- We will provide patches for supported versions
- We will credit security researchers who responsibly disclose vulnerabilities (with permission)

