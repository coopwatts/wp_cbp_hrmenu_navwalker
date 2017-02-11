# wp_cbp_hrmenu_navwalker
Wordpress Custom Navigation Walker for Horizontal Drop-Down Menu
Source Code for navigation menu was taken from: <a href="https://tympanus.net/codrops/2013/03/05/horizontal-drop-down-menu/">Codrops</a>
Walker was inspired by: <a href="https://github.com/twittem/wp-bootstrap-navwalker">Bootstrap Nav Walker</a>

# Synopsis
- Use the wp_cbp_hrmenu_navwalker to implement the Codrops Horiztontal Drop-Down Menu in your Wordpress theme.
- Allows the dynamic addition or removal of menu items through WordPress CMS

# Install:
1. Add the wp_cbp_hrmenu_navwalker.php file to your theme folder
2. Add require_once('wp_cbp_hrmenu_navwalker.php'); to your themes functions.php file
3. Ensure you have registered your navigation menu in your themes functions.php file via register_nav_menu();
4. Ensure all necessary CSS (cbpHorizontalMenu.css) and JS (cbpHorizontalMenu.js/cbpHorizontalMenu.min.js) files have been appropriately added to your project/theme folder

# Use:
1. Add the HTML for the navigation menu: `<nav role="navigation" id="cbp-hrmenu" class="cbp-hrmenu cbp-hrmenu-down"></nav>`

2. Call `wp_nav_menu()` between the `<nav></nav>` tags above

3. Don't forget to pass the walker object in `wp_nav_menu()` argument array: `array( ... 'walker' => new wp_cbp_hrmenu_navwalker() ...)`

4. Add pages, custom links, etc. in Wordpress CMS Menus section

5. Change the styles in the CSS file to suit your theme




