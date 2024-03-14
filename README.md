<p align="center">
  <a href="" rel="noopener">
  <img width=200px height=200px src="https://placehold.jp/000000/ffffff/200x200.png?text=DrevOps+Installer&css=%7B%22border-radius%22%3A%22%20100px%22%7D" alt="DrevOps Installer logo"></a>
</p>

<h1 align="center">Installer for <a href="https://github.com/drevops/drevops">DrevOps scaffold</a> project.</h1>

<div align="center">

[![GitHub Issues](https://img.shields.io/github/issues/drevops/installer.svg)](https://github.com/drevops/installer/issues)
[![GitHub Pull Requests](https://img.shields.io/github/issues-pr/drevops/installer.svg)](https://github.com/drevops/installer/pulls)
[![Test PHP](https://github.com/drevops/installer/actions/workflows/test-php.yml/badge.svg)](https://github.com/drevops/installer/actions/workflows/test-php.yml)
[![codecov](https://codecov.io/gh/drevops/installer/graph/badge.svg?token=K9SPETWCJR)](https://codecov.io/gh/drevops/installer)
![GitHub release (latest by date)](https://img.shields.io/github/v/release/drevops/installer)
![LICENSE](https://img.shields.io/github/license/drevops/installer)
![Renovate](https://img.shields.io/badge/renovate-enabled-green?logo=renovatebot)

</div>

---

<p align="center"> Installer for DrevOps scaffold project.
    <br>
</p>

> [!IMPORTANT]
> We are working on the v2 on the installer in
> the [`2.x`](https://github.com/drevops/installer/tree/2.x) branch.

## Installation

Download and run the latest version of the installer:

```bash
curl -SsL https://install.drevops.com > installer.php
php install.php
rm -r install.php
```

## Maintenance

    composer install
    composer lint
    composer test
