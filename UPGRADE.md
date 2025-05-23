# Upgrade Guide
## General Notes
## Upgrading from 3.x to 4.x

### Removed Expectation
As of v4, the Expectation has been removed. This will cause errors in your test suite if you upgrade and try to run it.
The recommended step is to remove it from your tests and set it as a composer script. You can also set it in any
CI/CD pipelines you have. 
