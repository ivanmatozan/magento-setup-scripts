## Matozan_Magento

A Magento 2 module for learning.

---

### Declarative Schema
- php bin/magento setup:upgrade:generate-whitelist (--module-name=MODULE-NAME)
- php bin/magento setup:upgrade --dry-run=1 (var/log/dry-run-installation.log)
- php bin/magento setup:upgrade --safe-mode=1 (var/declarative_dumps_csv/FILE.csv)
- php bin/magento setup:upgrade --data-restore=1 (--safe-mode=1)
