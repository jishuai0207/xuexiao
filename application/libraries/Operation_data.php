<?php
/**
 * 
 * @author liuguangping
 * @version 1.0 2013/10/8
 */
class Operation_data {
	public function __construct(){
		$this->CI =& get_instance();
	}
	
	/**
	 * 分页
	 */
	public function show_page(){
		$this->CI->load->library('pagination');
		$config['base_url'] = $this->base_url;
		$config['total_rows'] = $this->total_rows;
		$config['use_page_numbers'] = TRUE;
	
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = 'p';
	
		$config['uri_segment'] = 3;
        $config['num_links'] = 4;
	
		$config['first_link'] = ' 首页';
		$config['last_link'] = '尾页';
		$config['next_link'] = '下一页';
		$config['prev_link'] = '上一页';
		
		$config['per_page'] = $this->per_page;
		$this->CI->pagination->initialize($config);
		return $this->CI->pagination->create_links();
	}
	
	/**
	 * ajax分页
	 */
	public function show_page_ajax(){
		$this->CI->load->library('paginationajax');
		$config['base_url'] = $this->base_url;
		$config['total_rows'] = $this->total_rows;
		$config['use_page_numbers'] = TRUE;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = 'current_page';
		$config['uri_segment'] = 5;
        $config['num_links'] = 5;
		$config['first_link'] = '首页';
		$config['last_link'] = '尾页';
		$config['next_link'] = '下页';
		$config['prev_link'] = '上页';
		$config['per_page'] = $this->per_page;
		$config['cur_page'] = $this->cur_page;
		$this->CI->paginationajax->initialize($config);
		return $this->CI->paginationajax->create_links();
	}
}
