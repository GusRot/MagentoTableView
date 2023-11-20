# Module AdvancedTableView

## Overview
This module enhances the PLP by introducing an Advanced Table View option alongside the default grid and list views. The Advanced List View introduces several new features and customization options to improve the shopping experience.

## Installation details
```bash
composer require crimsonagility/module-advanced-table-view
```

Then run magento commands

```bash
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy -f
```

## Features:
- Advanced List View: Adds a table-based view to the Product Listing Page.
- Add All to Cart: A button to add all selected items from the list to the shopping cart.
- Selective Item Addition: Checkboxes allow users to select specific items for addition to the cart.
- Quantity Input: Each item includes a quantity input defaulted visually to 0.
- Auto-Select Quantity: Quantity fields are auto-selected when the input is changed to a value greater than 0.

## Configurable Options:
- Enable/Disable Module: Toggle the Advanced List View feature on/off.
- Configurations per store view and website as well
- Set Default View: Select whether the Table View should be the default view for the PLP.
- Customer Group Permissions: Manage which Customer Groups have access to the Advanced List View.
- Column Customization: Configure visible columns in the table view:
    - Image
    - Product Name
    - SKU
    - Description
    - Price
    - Secondary Actions (wishlist/compare/req-list)
    - Actions
    - Mass Add to cart
    

### Frontend Usage:
- Once installed and configured, visit the Product Listing Page to access the Advanced List View option. Users can switch between grid, list, and table views using the view options.
- Use checkboxes to select specific items.
- Change quantity inputs as needed.
- Use "Add All to Cart" buttons to add selected items to the shopping cart.
- Inputs will be disabled if out of stock

### Screenshots:
![Image Alt Text](./AdvancedTableView/docs/AdvancedTableView(front).jpg)
![Image Alt Text](./AdvancedTableView/docs/AdvancedTableView(backend).jpg)

## Documentation of the task
B2B Category Page - Advanced List View -> CA-5069

### Future Development:
- Add configurations in the category scope as well