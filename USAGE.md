# FIRST Knowledge Vault Plugin - Usage Guide

## Installation
1. Upload the `first-knowledge-vault` folder to your WordPress `wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. You will see a new menu item "FIRST Knowledge Vault" in the admin dashboard.

## Content Management
1. Go to **FIRST Knowledge Vault > Add New Entry**.
2. Enter the Title and Description.
3. In the right sidebar, select **Category**, **Year**, **Team**, and **Award**.
4. Set a **Featured Image** (Thumbnail) for the card.
5. In the **Vault PDF File** box (right sidebar), enter the URL of the PDF or select it from the media library.
6. Publish the post.

## Shortcodes
Place these shortcodes on any page to display the vault.

- `[first_vault_home]`: Display the full archive with search and filters.
- `[first_vault_ftc]`: Display only 'FTC Manual' category content.
- `[first_vault_deans]`: Display only 'Dean's List Essay' category content.
- `[first_vault_team id="1234"]`: Display content for a specific team (replace 1234 with exact team slug).

## Features
- **Search & Filter**: Real-time filtering by category, year, team, and award.
- **Dark Mode**: Toggled via the moon icon on the frontend.
- **PDF Viewer**: pop-up modal to view PDFs directly on the page.
