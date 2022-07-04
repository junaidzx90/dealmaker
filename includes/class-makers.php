<?php
class Dealmaker_Makers extends WP_List_Table
{
    /**
     * Prepare the items for the table to process
     *
     * @return Void
     */
    public function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();
        $action = $this->current_action();

        $data = $this->table_data();
        usort($data, array(&$this, 'usort_reorder'));

        $perPage = 10;
        $currentPage = $this->get_pagenum();
        $totalItems = count($data);

        $this->set_pagination_args(array(
            'total_items' => $totalItems,
            'per_page' => $perPage,
        ));

        $data = array_slice($data, (($currentPage - 1) * $perPage), $perPage);
        $this->_column_headers = array($columns, $hidden, $sortable);
      
        $this->items = $data;
    }

    // Sorting function
    function usort_reorder($a, $b)
    {
        // If no sort, default to user_login
        $orderby = (!empty($_GET['orderby'])) ? $_GET['orderby'] : 'ID';
        // If no order, default to asc
        $order = (!empty($_GET['order'])) ? $_GET['order'] : 'desc';
        // Determine sort order
        $result = strnatcmp($a[$orderby], $b[$orderby]);
        
        // Send final sort direction to usort
        return ($order === 'asc') ? $result : -$result;
    }
    
    /**
     * Override the parent columns method. Defines the columns to use in your listing table
     *
     * @return Array
     */
    public function get_columns()
    {
        $columns = array(
            'cb' => '<input type="checkbox" name="maker[]" />',
            'title' => 'Title',
            'shortcode' => 'Shortcode',
            'date' => 'Create date'
        );

        return $columns;
    }

    /**
     * Define which columns are hidden
     *
     * @return Array
     */
    public function get_hidden_columns()
    {
        return array();
    }

    /**
     * Define the sortable columns
     *
     * @return Array
     */
    public function get_sortable_columns()
    {
        return array(
            'date' => array('date', true),
            'date' => array('date', true)
        );
    }    

    /**
     * Get the table data
     *
     * @return Array
     */
    private function table_data()
    {
        global $wpdb;
        $data = array();

        $results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}dealmaker");
        if($results){
            foreach($results as $result){
                $array = [
                    'ID' => $result->ID,
                    'title' => $result->title,
                    'shortcode' => $result->ID,
                    'date' => date("F j, Y, g:i a", strtotime($result->date))
                ];
                $data[] = $array;
            }
        }

        return $data;
    }

    /**
     * Define what data to show on each column of the table
     *
     * @param  Array $item        Data
     * @param  String $column_name - Current column name
     *
     * @return Mixed
     */
    public function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'shortcode':
                return '<input type="text" readonly value=\'[dealmaker id="'.$item[$column_name].'"]\'>';
            case $column_name:
                return $item[$column_name];
            default:
                return print_r($item, true);
        }
    }

    public function column_title($item){
        $actions = array(
            'mange' => '<a href="?page=dealmaker&action=manage&maker='.$item['ID'].'">Manage</a>',
            'delete' => '<a href="?page=dealmaker&action=delete&maker='.$item['ID'].'">Delete</a>',
        );

        return sprintf('%1$s %2$s', $item['title'], $this->row_actions($actions));
    }

    public function get_bulk_actions(){
        $actions = array(
            'delete' => 'Delete',
        );
        return $actions;
    }

    public function column_cb($item){
        return sprintf(
            '<input type="checkbox" name="maker[]" value="%s" />', $item['ID']
        );
    }

    // All form actions
    public function current_action(){
        global $wpdb;
        if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete' && isset($_REQUEST['maker'])) {
            if(is_array($_REQUEST['maker'])){
                $ids = $_REQUEST['maker'];
                foreach($ids as $ID){
                    
                }
            }else{
                $ID = intval($_REQUEST['maker']);
                
            }
        }
    }

} //class