# Image upload & preview setup (Windows/XAMPP)

Image uploads are stored on Laravel's `public` filesystem disk at `storage/app/public`. Browser-visible URLs use the `public` disk directly. The upload forms now show client-side image previews for gallery, products, banners, and event covers.

## Required local setup

From the project root (`D:\\JOJO\\direktoriumkmputatjaya`):

```powershell
php artisan storage:link
php artisan config:clear
php artisan view:clear
```

The symlink must exist at `public/storage` and point to `storage/app/public`. On Windows, if `storage:link` reports a permission error, enable Windows Developer Mode or run PowerShell as Administrator, then retry. If the link is stale, remove `public/storage` (only the symlink, not `storage/app/public`) and recreate it.

Check `.env` has the host used to open the site, for example:

```dotenv
APP_URL=http://127.0.0.1:8000
FILESYSTEM_DISK=public
```

Restart the Laravel server after changing `.env`.

## PHP upload limits

For multiple images in one request, `post_max_size` must exceed the combined image sizes. In the `php.ini` used by your CLI/web server set:

```ini
file_uploads=On
upload_max_filesize=10M
post_max_size=64M
max_file_uploads=20
```

Restart Apache/PHP after editing `php.ini`. The app accepts JPG/JPEG, PNG and WEBP images up to 5 MB each, maximum 10 at a time. PHP must have Fileinfo enabled for image validation.

If saving still fails, check `storage/logs/laravel.log`; the public disk now throws instead of silently returning a failed storage path. Verify the web-server user can write to `storage/app/public`.
