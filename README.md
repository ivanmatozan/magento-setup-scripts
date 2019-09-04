## Matozan_Magento

A Magento 2 module for learning.

---

### Declarative Schema
- php bin/magento setup:db-declaration:generate-whitelist (--module-name=MODULE-NAME)
- php bin/magento setup:upgrade --dry-run=1 (var/log/dry-run-installation.log)
- php bin/magento setup:upgrade --safe-mode=1 (var/declarative_dumps_csv/FILE.csv)
- php bin/magento setup:upgrade --data-restore=1 (--safe-mode=1)

---

### EAV property mappers
- Magento\Eav\Model\Entity\Setup\PropertyMapperInterface
- Magento\Eav\Model\Entity\Setup\PropertyMapper\Composite
- Magento\Eav\Model\Entity\Setup\PropertyMapper
- Magento\Catalog\Model\ResourceModel\Setup\PropertyMapper
- Magento\Customer\Model\ResourceModel\Setup\PropertyMapper
- Magento\ConfigurableProduct\Model\ResourceModel\Setup\PropertyMapper
- Magento\CatalogSearch\Model\ResourceModel\Setup\PropertyMapper

---

### Router list (Magento\Framework\App\RouterList)

**frontend:** 
- 10 => robots (Magento\Robots\Controller\Router)
- 20 => urlrewrite (Magento\UrlRewrite\Controller\Router)
- 30 => standard (Magento\Framework\App\Router\Base)
- 60 => cms (Magento\Cms\Controller\Router)
- 100 => default (Magento\Framework\App\Router\DefaultRouter)

**adminhtml:**
- 10 => admin (Magento\Backend\App\Router)
- 100 => default (Magento\Framework\App\Router\DefaultRouter)

---
