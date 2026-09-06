# Quick Start Guide - Investing System

## Access the System

### Start the Server
```bash
cd /home/elkomy/Desktop/work/myWork/investing
php artisan serve
```

### Login to Admin Panel
- **URL**: http://127.0.0.1:8000/admin
- **Email**: admin@example.com
- **Password**: password

## Main Features

### 📊 Dashboard
- View total deposits amount
- View total withdrawals amount
- See your balance (deposits - withdrawals)
- All statistics update in real-time

### 💰 Deposits
- Click "Deposits" in left sidebar
- Click "Create" button to add new deposit
- Modal popup appears with form fields:
  - **Amount**: Enter deposit amount (with $ prefix)
  - **Deposit Date**: Pick the deposit date
  - **Description**: Optional notes about the deposit
- Fill form and click "Create" to save
- Edit existing deposits by clicking the row
- Delete deposits using the checkboxes and bulk delete option

### 🏦 Withdrawals
- Click "Withdrawals" in left sidebar
- Click "Create" button to add new withdrawal
- Modal popup appears with form fields:
  - **Amount**: Enter withdrawal amount (with $ prefix)
  - **Withdrawal Date**: Pick the withdrawal date
  - **Description**: Optional notes about the withdrawal
- Fill form and click "Create" to save
- Edit existing withdrawals by clicking the row
- Delete withdrawals using the checkboxes and bulk delete option

## Navigation Icons
- 🏠 Dashboard - Home/Overview
- ⬆️ Deposits - Arrow up circle (Manage deposits)
- ⬇️ Withdrawals - Arrow down circle (Manage withdrawals)
- 👤 Account - User account settings

## Tips & Tricks

### Searching
- Click on "User" column header to search by user name
- Use the search box to filter records

### Sorting
- Click column headers (Amount, Date) to sort ascending/descending
- Click again to reverse sort direction

### Editing
- Click any row to edit the record
- A modal form will appear
- Update the information and click "Update"

### Deleting
- Check the checkbox(es) for records to delete
- Click "Delete selected" in the toolbar
- Confirm the deletion

### Forms
- All forms open in modal popups (non-intrusive)
- Required fields are marked with asterisks (*)
- Dates use a date picker for easy selection
- Amounts accept decimal values (e.g., 1000.50)

## Database Info

### Seeded User
- Email: admin@example.com
- Password: password
- Name: Admin User

### Tables
- **deposits**: Stores all deposit transactions
- **withdrawals**: Stores all withdrawal transactions
- **users**: Stores user information

## Troubleshooting Quick Fixes

### Server not starting?
```bash
# Kill any existing process
pkill -f "php artisan serve"

# Start fresh
php artisan serve
```

### Can't login?
```bash
# Reseed the database
php artisan db:seed
```

### Filament not loading?
```bash
# Clear caches
php artisan cache:clear
php artisan view:clear

# Restart server
```

## File Locations

Key files you might need to modify:

```
app/
├── Models/
│   ├── Deposit.php          ← Deposit model
│   ├── Withdrawal.php       ← Withdrawal model
│   └── User.php             ← User model (updated)
├── Filament/
│   ├── Resources/
│   │   ├── Deposits/        ← Deposit resource & forms
│   │   └── Withdrawals/     ← Withdrawal resource & forms
│   ├── Pages/
│   │   └── Dashboard.php    ← Custom dashboard
│   └── Widgets/
│       └── DepositWithdrawalStats.php  ← Dashboard stats
```

## Environment Settings

Check `.env` file for:
- `DB_DATABASE` - Database name (default: database.sqlite)
- `APP_URL` - Application URL (default: http://localhost)

## Support
If you encounter issues, refer to:
- `FILAMENT_SYSTEM.md` - Complete documentation
- Laravel docs: https://laravel.com/docs
- Filament docs: https://filamentphp.com/docs

---
**Ready to go! Happy investing! 💼**
