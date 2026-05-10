# Investing System with Filament

## Overview
A comprehensive investment tracking system built with Laravel 12 and Filament v5, featuring deposit and withdrawal management with a beautiful admin dashboard.

## Features Implemented

### ✅ Authentication & Login System
- Built-in Laravel authentication
- Filament admin login page
- Admin panel protected with authentication middleware
- Test user credentials:
  - Email: `admin@example.com`
  - Password: `password`

### ✅ Deposits Management
- **Model**: `App\Models\Deposit`
- **Fields**:
  - `user_id` - Foreign key to users table
  - `amount` - Decimal value (15, 2) for deposit amount
  - `deposit_date` - Date of the deposit
  - `description` - Optional description
  - `timestamps` - Created and updated timestamps

- **Filament Resource**: `App\Filament\Resources\Deposits\DepositResource`
  - List view with sortable and searchable columns
  - Modal-based create form
  - Modal-based edit form
  - Delete bulk actions
  - User, Amount (formatted as USD), Deposit Date, and Description columns

### ✅ Withdrawals Management
- **Model**: `App\Models\Withdrawal`
- **Fields**:
  - `user_id` - Foreign key to users table
  - `amount` - Decimal value (15, 2) for withdrawal amount
  - `withdrawal_date` - Date of the withdrawal
  - `description` - Optional description
  - `timestamps` - Created and updated timestamps

- **Filament Resource**: `App\Filament\Resources\Withdrawals\WithdrawalResource`
  - List view with sortable and searchable columns
  - Modal-based create form
  - Modal-based edit form
  - Delete bulk actions
  - User, Amount (formatted as USD), Withdrawal Date, and Description columns

### ✅ Dashboard with Statistics
- **Dashboard Widget**: `App\Filament\Widgets\DepositWithdrawalStats`
- **Statistics Displayed**:
  - **Total Deposits**: Sum of all user deposits with trending up icon
  - **Total Withdrawals**: Sum of all user withdrawals with trending down icon
  - **Balance**: Deposits minus withdrawals (shows success color if positive, danger if negative)

- **Dashboard Page**: `App\Filament\Pages\Dashboard`
  - Custom dashboard replacing default Filament dashboard
  - Displays statistics widget prominently
  - Account widget and Filament info widget included

### ✅ Modal-Based Forms
All inputs are configured to use popup/modal forms:
- Create Deposit: Opens in modal dialog
- Edit Deposit: Opens in modal dialog
- Create Withdrawal: Opens in modal dialog
- Edit Withdrawal: Opens in modal dialog
- Modal forms provide clean, non-intrusive user experience

## Project Structure

```
app/
├── Models/
│   ├── Deposit.php
│   ├── Withdrawal.php
│   └── User.php (updated with relationships)
├── Filament/
│   ├── Resources/
│   │   ├── Deposits/
│   │   │   ├── DepositResource.php
│   │   │   ├── Pages/
│   │   │   │   ├── CreateDeposit.php
│   │   │   │   ├── EditDeposit.php
│   │   │   │   └── ListDeposits.php
│   │   │   ├── Schemas/
│   │   │   │   └── DepositForm.php
│   │   │   └── Tables/
│   │   │       └── DepositsTable.php
│   │   └── Withdrawals/
│   │       ├── WithdrawalResource.php
│   │       ├── Pages/
│   │       │   ├── CreateWithdrawal.php
│   │       │   ├── EditWithdrawal.php
│   │       │   └── ListWithdrawals.php
│   │       ├── Schemas/
│   │       │   └── WithdrawalForm.php
│   │       └── Tables/
│   │           └── WithdrawalsTable.php
│   ├── Pages/
│   │   └── Dashboard.php
│   └── Widgets/
│       └── DepositWithdrawalStats.php
└── Providers/
    └── Filament/
        └── AdminPanelProvider.php
database/
├── migrations/
│   ├── 2026_01_26_140835_create_deposits_table.php
│   └── 2026_01_26_140836_create_withdrawals_table.php
└── seeders/
    ├── DatabaseSeeder.php
    └── UserSeeder.php
```

## Installation & Setup

### Prerequisites
- PHP 8.2+
- Laravel 12
- Composer
- SQLite or MySQL

### Steps Already Completed
1. ✅ Laravel 12 installation
2. ✅ Filament v5.1.0 installation
3. ✅ PHP intl extension installation
4. ✅ Models created with relationships
5. ✅ Database migrations created and executed
6. ✅ Filament resources created with forms and tables
7. ✅ Dashboard widget created
8. ✅ Database seeded with admin user

### Running the Application

```bash
cd /home/elkomy/Desktop/work/myWork/investing

# Start the development server
php artisan serve

# Visit the admin panel
# http://127.0.0.1:8000/admin
```

### Login Credentials
- **Email**: admin@example.com
- **Password**: password

## Form Fields Documentation

### Deposit Form (Modal)
- **Amount** (Required): Text input with $ prefix, accepts decimal values (step: 0.01)
- **Deposit Date** (Required): Date picker
- **Description** (Optional): Textarea for additional notes
- **User ID**: Auto-filled with current authenticated user

### Withdrawal Form (Modal)
- **Amount** (Required): Text input with $ prefix, accepts decimal values (step: 0.01)
- **Withdrawal Date** (Required): Date picker
- **Description** (Optional): Textarea for additional notes
- **User ID**: Auto-filled with current authenticated user

## Table Columns

### Deposits Table
| Column | Type | Features |
|--------|------|----------|
| User | Text | Searchable, links to user |
| Amount | Money | Formatted as USD, Sortable |
| Deposit Date | Date | Sortable |
| Description | Text | Limited to 50 characters |

### Withdrawals Table
| Column | Type | Features |
|--------|------|----------|
| User | Text | Searchable, links to user |
| Amount | Money | Formatted as USD, Sortable |
| Withdrawal Date | Date | Sortable |
| Description | Text | Limited to 50 characters |

## Navigation
- **Dashboard**: Overview with statistics
- **Deposits**: Arrow up icon (heroicon-o-arrow-up-circle) - Manage deposits
- **Withdrawals**: Arrow down icon (heroicon-o-arrow-down-circle) - Manage withdrawals

## Database Schema

### Deposits Table
```sql
CREATE TABLE deposits (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    amount DECIMAL(15, 2) NOT NULL,
    deposit_date DATE NOT NULL,
    description VARCHAR(255) NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Withdrawals Table
```sql
CREATE TABLE withdrawals (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    amount DECIMAL(15, 2) NOT NULL,
    withdrawal_date DATE NOT NULL,
    description VARCHAR(255) NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

## Key Features & Technologies

### Laravel Features Used
- Eloquent ORM with relationships
- Database migrations
- Seeders for test data
- Authentication (built-in)

### Filament Features Used
- Admin panel with Livewire
- Resource management
- Modal forms (popup-based)
- Data tables with actions
- Stats overview widget
- Custom dashboard
- Role-based access (configurable)

### UI/UX Features
- Modal-based forms for clean user experience
- Currency formatting for amounts
- Date pickers for date fields
- Searchable and sortable columns
- Bulk delete actions
- Color-coded statistics (success/danger)

## API Relationships

### User Model
```php
- hasMany('deposits'): One user can have many deposits
- hasMany('withdrawals'): One user can have many withdrawals
```

### Deposit Model
```php
- belongsTo('user'): Each deposit belongs to a user
```

### Withdrawal Model
```php
- belongsTo('user'): Each withdrawal belongs to a user
```

## Future Enhancements (Optional)
- Export deposits/withdrawals to CSV/Excel
- Monthly/yearly reports
- Charts and graphs for visualization
- Transaction filters and date ranges
- Multi-currency support
- Transaction notifications
- Approval workflow for withdrawals
- Balance history tracking
- User roles and permissions

## Troubleshooting

### Server won't start
```bash
# Make sure PHP intl extension is installed
php -m | grep intl

# Reinstall if needed
sudo apt-get install php8.2-intl
```

### Database errors
```bash
# Run migrations if needed
php artisan migrate

# Refresh database (warning: deletes all data)
php artisan migrate:refresh --seed
```

### Filament not loading
```bash
# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Republish assets
php artisan filament:install --assets
```

## Support & Documentation
- [Laravel Documentation](https://laravel.com/docs)
- [Filament Documentation](https://filamentphp.com/docs)
- [Eloquent ORM](https://laravel.com/docs/eloquent)

---

**System Created**: January 26, 2026
**Laravel Version**: 12
**Filament Version**: 5.1.0
**PHP Version**: 8.2.30
