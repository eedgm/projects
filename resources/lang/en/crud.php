<?php

return [
    'common' => [
        'actions' => 'Actions',
        'create' => 'Create',
        'edit' => 'Edit',
        'update' => 'Update',
        'new' => 'New',
        'cancel' => 'Cancel',
        'attach' => 'Attach',
        'detach' => 'Detach',
        'save' => 'Save',
        'delete' => 'Delete',
        'delete_selected' => 'Delete selected',
        'search' => 'Search...',
        'back' => 'Back to Index',
        'are_you_sure' => 'Are you sure?',
        'no_items_found' => 'No items found',
        'created' => 'Successfully created',
        'saved' => 'Saved successfully',
        'removed' => 'Successfully removed',
    ],

    'clients' => [
        'name' => 'Clients',
        'index_title' => 'Clients List',
        'new_title' => 'New Client',
        'create_title' => 'Create Client',
        'edit_title' => 'Edit Client',
        'show_title' => 'Show Client',
        'inputs' => [
            'logo' => 'Logo',
            'name' => 'Name',
            'owner' => 'Owner',
            'phone' => 'Phone',
            'website' => 'Website',
            'cost_hour' => 'Cost Hour',
            'user_id' => 'User',
            'direction' => 'Direction',
        ],
    ],

    'events' => [
        'name' => 'Events',
        'index_title' => 'Events List',
        'new_title' => 'New Event',
        'create_title' => 'Create Event',
        'edit_title' => 'Edit Event',
        'show_title' => 'Show Event',
        'inputs' => [
            'name' => 'Name',
            'process' => 'Process',
        ],
    ],

    'fields' => [
        'name' => 'Fields',
        'index_title' => 'Fields List',
        'new_title' => 'New Field',
        'create_title' => 'Create Field',
        'edit_title' => 'Edit Field',
        'show_title' => 'Show Field',
        'inputs' => [
            'name' => 'Name',
            'html' => 'Html',
            'enable' => 'Enable',
            'preview' => 'Preview',
        ],
    ],

    'products' => [
        'name' => 'Products',
        'index_title' => 'Products List',
        'new_title' => 'New Product',
        'create_title' => 'Create Product',
        'edit_title' => 'Edit Product',
        'show_title' => 'Show Product',
        'inputs' => [
            'client_id' => 'Client',
            'name' => 'Name',
            'description' => 'Description',
        ],
    ],

    'product_descriptions' => [
        'name' => 'Product Descriptions',
        'index_title' => 'ProductDescriptions List',
        'new_title' => 'New Product description',
        'create_title' => 'Create ProductDescription',
        'edit_title' => 'Edit ProductDescription',
        'show_title' => 'Show ProductDescription',
        'inputs' => [
            'label' => 'Label',
            'product_id' => 'Product',
            'field_id' => 'Field',
        ],
    ],

    'works' => [
        'name' => 'Works',
        'index_title' => 'Works List',
        'new_title' => 'New Work',
        'create_title' => 'Create Work',
        'edit_title' => 'Edit Work',
        'show_title' => 'Show Work',
        'inputs' => [
            'client_id' => 'Client',
            'product_id' => 'Product',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
            'hours' => 'Hours',
            'cost' => 'Cost',
            'statu_id' => 'Statu',
            'total' => 'Total',
        ],
    ],

    'users' => [
        'name' => 'Users',
        'index_title' => 'Users List',
        'new_title' => 'New User',
        'create_title' => 'Create User',
        'edit_title' => 'Edit User',
        'show_title' => 'Show User',
        'inputs' => [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
        ],
    ],

    'client_products' => [
        'name' => 'Client Products',
        'index_title' => 'Products List',
        'new_title' => 'New Product',
        'create_title' => 'Create Product',
        'edit_title' => 'Edit Product',
        'show_title' => 'Show Product',
        'inputs' => [
            'name' => 'Name',
            'description' => 'Description',
        ],
    ],

    'product_works' => [
        'name' => 'Product Works',
        'index_title' => 'Works List',
        'new_title' => 'New Work',
        'create_title' => 'Create Work',
        'edit_title' => 'Edit Work',
        'show_title' => 'Show Work',
        'inputs' => [
            'client_id' => 'Client',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
            'hours' => 'Hours',
            'statu_id' => 'Statu',
        ],
    ],

    'product_product_descriptions' => [
        'name' => 'Product Product Descriptions',
        'index_title' => 'ProductDescriptions List',
        'new_title' => 'New Product description',
        'create_title' => 'Create ProductDescription',
        'edit_title' => 'Edit ProductDescription',
        'show_title' => 'Show ProductDescription',
        'inputs' => [
            'label' => 'Label',
            'field_id' => 'Field',
        ],
    ],

    'field_product_descriptions' => [
        'name' => 'Field Product Descriptions',
        'index_title' => 'ProductDescriptions List',
        'new_title' => 'New Product description',
        'create_title' => 'Create ProductDescription',
        'edit_title' => 'Edit ProductDescription',
        'show_title' => 'Show ProductDescription',
        'inputs' => [
            'label' => 'Label',
            'product_id' => 'Product',
        ],
    ],

    'user_clients' => [
        'name' => 'User Clients',
        'index_title' => 'Clients List',
        'new_title' => 'New Client',
        'create_title' => 'Create Client',
        'edit_title' => 'Edit Client',
        'show_title' => 'Show Client',
        'inputs' => [
            'owner' => 'Owner',
            'phone' => 'Phone',
            'name' => 'Name',
            'website' => 'Website',
            'logo' => 'Logo',
            'direction' => 'Direction',
        ],
    ],

    'user_works' => [
        'name' => 'User Works',
        'index_title' => ' List',
        'new_title' => 'New User work',
        'create_title' => 'Create user_work',
        'edit_title' => 'Edit user_work',
        'show_title' => 'Show user_work',
        'inputs' => [
            'work_id' => 'Work',
        ],
    ],

    'work_users' => [
        'name' => 'Work Users',
        'index_title' => ' List',
        'new_title' => 'New User work',
        'create_title' => 'Create user_work',
        'edit_title' => 'Edit user_work',
        'show_title' => 'Show user_work',
        'inputs' => [
            'user_id' => 'User',
        ],
    ],

    'statuses' => [
        'name' => 'Statuses',
        'index_title' => 'Statuses List',
        'new_title' => 'New Status',
        'create_title' => 'Create Status',
        'edit_title' => 'Edit Status',
        'show_title' => 'Show Status',
        'inputs' => [
            'name' => 'Name',
            'color' => 'Color',
            'client_id' => 'Client',
            'event_id' => 'Event',
        ],
    ],

    'status_works' => [
        'name' => 'Status Works',
        'index_title' => 'Works List',
        'new_title' => 'New Work',
        'create_title' => 'Create Work',
        'edit_title' => 'Edit Work',
        'show_title' => 'Show Work',
        'inputs' => [
            'client_id' => 'Client',
            'product_id' => 'Product',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
            'hours' => 'Hours',
            'cost' => 'Cost',
        ],
    ],

    'event_status' => [
        'name' => 'Event Status',
        'index_title' => 'Statuses List',
        'new_title' => 'New Status',
        'create_title' => 'Create Status',
        'edit_title' => 'Edit Status',
        'show_title' => 'Show Status',
        'inputs' => [
            'name' => 'Name',
            'color' => 'Color',
            'client_id' => 'Client',
        ],
    ],

    'roles' => [
        'name' => 'Roles',
        'index_title' => 'Roles List',
        'create_title' => 'Create Role',
        'edit_title' => 'Edit Role',
        'show_title' => 'Show Role',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'permissions' => [
        'name' => 'Permissions',
        'index_title' => 'Permissions List',
        'create_title' => 'Create Permission',
        'edit_title' => 'Edit Permission',
        'show_title' => 'Show Permission',
        'inputs' => [
            'name' => 'Name',
        ],
    ],
];
