<?php

namespace App\Models\Back;

use CodeIgniter\Model;
 
class AuthModel extends Model
{
    protected $table   = 'tbl_users';

    public function login($user, $pwd, $locale)
    {

        $qry = $this->db->query("SELECT * FROM tbl_users WHERE user_name=?", array($user));
        $data = $qry->getRowArray();

        if ($data != null) {

            $db_pwd = $data['passwd'];
            $brid = $data['branch_id'];

            // check password
            if (password_verify($pwd, $db_pwd)) {

                if ($data['user_status'] == 'Active') {

                    $user_id = $data['user_id'];

                    $userdata = [
                        'user' => $data,
                        'ut_id' => $user_id,
                        'isLoggedIn' => true,
                        'branch_name' => 'Barakaale Apartment'
                    ];

                    return [
                        'success' => true,
                        'message' => 'Login Successful',
                        'sess' => $userdata
                    ];
                } else return ['success' => 0, 'message' => 'Login Successful'];
            } else return ['success' => 0, 'message' => 'Invalid Password.'];;
        } else return ['success' => 0, 'message' => 'Invalid UserName'];;
    }

    public function get_user_access($user_id , $locale){

        /**
         * This query retrieves the details of the top-level menu tabs (where tab_parent = 0) 
         * that are accessible to the specified user (based on the user_id).
         * It selects the following fields from the 'tbl_menu' table:
         *              - tab_id: The unique identifier for each tab.
         *              - tab_name_en: The name of the tab in English.
         *              - tab_name_ar: The name of the tab in Arabic.- tab_icon: The icon associated with the tab.
         *              - tab_url: The URL linked to the tab.
         *              - tab_parent: The parent identifier, which is 0 for top-level menu items.
         *              - tab_order: The order in which the tab should appear in the menu.
         * The query joins the 'tbl_menu' table with the 'tbl_menu_access' table on the tab_id field 
         * to ensure that only the tabs that the specified user has access to are returned. 
         * It filters for tabs where tab_parent = '0' (top-level menu items) 
         * and where the user has access (ma.user_id = '$user_id'). 
         * The results are ordered by 'tab_order' in ascending order to display the menu in the correct order.
         */
        $qry = $this->db->query("SELECT m.tab_id, m.tab_name_en, m.tab_name_en, m.tab_name_ar,m.tab_icon, m.tab_url, m.tab_parent, m.tab_order
        FROM tbl_menu m JOIN tbl_menu_access ma ON m.tab_id = ma.tab_id WHERE m.tab_parent='0' AND ma.user_id='$user_id'  order by tab_order asc");
        $rec = $qry->getResultArray();

        // Execute the query to retrieve the result set as an array
        // This contains the top-level menu items the user has access to
        $rec = $qry->getResultArray();

        // Initialize the variable for the sidebar list HTML structure
        $p_li = ''; 
        $ptab = ''; // Variable to hold the name of each tab (in the correct language)

        // Iterate through the results (top-level menu items)
        foreach ($rec as $val) {

            // Determine the tab name based on the user's locale (language)
            if ($locale == 'ar') {
                $ptab = $val['tab_name_ar']; // Use Arabic name if locale is 'ar'
            } else {
                $ptab = $val['tab_name_en']; // Use English name if locale is not 'ar'
            }

            // Build the HTML for the current menu item (sidebar item) with a link
            $p_li .= '<li class="sidebar-item">
                <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                    <i data-feather="' . $val['tab_icon'] . '" class="feather-icon"></i>
                    <span class="hide-menu">' . $ptab . ' </span>
                </a>';

            // Query to retrieve the submenus for the current top-level tab (only accessible to the user)
            // These are the second-level menu items under the current top-level item
            $sub_menus = $this->db->query("SELECT m.tab_id, m.tab_name_en, m.tab_name_ar, m.tab_icon, m.tab_url, m.tab_parent, m.tab_order 
            FROM tbl_menu m JOIN tbl_menu_access ma ON m.tab_id = ma.tab_id where m.tab_parent = '" . $val['tab_id'] . "' AND ma.user_id='$user_id' ")->getResult();

            // Start building the HTML for the submenus (collapsed by default)
            $p_li .= '<ul aria-expanded="false" class="collapse  first-level">';
            $ch_li = ''; // Initialize the HTML for the sub-menu list items

            // Loop through the submenus for the current top-level tab
            foreach ($sub_menus as $menu) {

                // Determine the submenu tab name based on the user's locale (language)
                if ($locale == 'ar') {
                    $chtab = $menu->tab_name_ar; // Use Arabic name for the submenu if locale is 'ar'
                } else {
                    $chtab = $menu->tab_name_en; // Use English name for the submenu if locale is not 'ar'
                }

                // Build the HTML for each submenu item (with a link to the submenu's URL)
                $ch_li .= '<li class="sidebar-item">
                    <a href="' . base_url($locale . '/') . $menu->tab_url . '" class="sidebar-link">
                        <i class="mdi mdi-adjust"></i><span class="hide-menu">' . $chtab . '</span>
                    </a>
                </li>';
            }

            // Append the submenu items to the main menu list (nested inside <ul>)
            $p_li .= $ch_li;

            // Close the <ul> and <li> tags for the current menu item (top-level)
            $p_li .= '</ul></li>';
        }

        // Return the generated HTML for the entire sidebar list (menu with submenus)
        return $p_li;

    }
}
