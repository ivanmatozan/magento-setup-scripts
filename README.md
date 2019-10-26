# Matozan_SetupScripts

Learning Magento 2 Setup Scripts (Mage2 TV)

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
