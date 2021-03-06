<?php

class Home extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('M_data');
                $this->load->helper('url');
	}

	function index(){
		$data['hasil'] = $this->M_data->tampil_kategori_iki();
		$data['data']=$this->M_data->get_all_produk();
		$data['hasil3'] = $this->M_data->tampil_kategori_itu()->result();
		$data['hasil2'] = $this->M_data->tampil_last_product()->result();
		$data['hasil4'] = $this->M_data->tampil_kategori_itu2()->result();
		$data['hasil7'] = $this->M_data->tampil_slider()->result();
		$data['hasil5'] = $this->M_data->tampil_kategori_itu3()->result();
		$data['hasil6'] = $this->M_data->tampil_kategori_itu4()->result();
		$id_usr = $this->session->userdata("nama");
		$data['hasil8'] = $this->M_data->tampil_id_user($id_usr)->result();
		$data['barang_fashion'] = $this->M_data->tampil_barang_fashion()->result();
		$data['barang_barokah'] = $this->M_data->tampil_barang_barokah()->result();

		if($this->session->userdata('status') != "login"){
			$this->load->view('Home/Atas',$data);
                        $this->session->set_userdata('username','1');
		}else {
			$this->load->view('Home/Atas2',$data);
		}
		$this->load->view('Home/Header',$data);
	}



		function add_to_cart(){ //fungsi Add To Cart
		$data = array(
			'id' => $this->input->post('id_barang'),
			'name' => $this->input->post('nama_barang'),
			'price' => $this->input->post('harga_jual'),
			'qty' => $this->input->post('banyak'),
		);
		$this->cart->insert($data);
		echo $this->show_cart(); //tampilkan cart setelah added
	}
function show_cart2(){ //Fungsi untuk menampilkan Cart
		$output = '';
		$no = 0;
		foreach ($this->cart->contents() as $items) {
			$no++;
			$output .='
				<li class="row">
											<span class="quantity">'.$items['qty'].'</span>
						<span class="itemName">'.$items['name'].'</span>
						<span class="popbtn">
											<button id="'.$items['rowid'].'" class="hapus_cart2 btn btn-danger" data-toggle="modal" data-target="#hapus"><i class="fa fa-trash"></i></button>
</span>

						<span class="price">'.number_format($items['subtotal']).'</span>
				</li>

			';
		}
		$output .= '

		<li class="row totals">
						<span class="itemName">Total:</span>
						<span class="price">'.' Rp '.number_format($this->cart->total()).'</span>
						<span class="order"> <a class="text-center">CHECKOUT</a></span>
					</li>

		';
		return $output;
	}
	function show_cart3(){ //Fungsi untuk menampilkan Cart
		$output = '';
		$no = 0;
		foreach ($this->cart->contents() as $items) {
			$no++;
			$output .='
			<tr>
										<td class="thumb"><img src="./img/thumb-product01.jpg" alt=""></td>
										<td class="details">
											<a href="#">'.$items['name'].'</a>

										</td>
										<td class="qty text-center"><input class="input" type="number" value="'.$items['qty'].'"></td>

										<td class="total text-center"><strong class="primary-color">'.number_format($items['subtotal']).'</strong></td>
										<td class="text-right"><button id="'.$items['rowid'].'" class="main-btn icon-btn"><i class="fa fa-close"></i></button></td>
									</tr>

			';
		}
		$output .= '

<tr>
						<td><span class="itemName">Total:</span></td>
						<td><span class="price">'.' Rp '.number_format($this->cart->total()).'</span></td>
						<td></td>
						<td></td>
						<td><span class="order" style="float:right !important"> <a class="text-center">CHECKOUT</a></span></td>
	</tr>

		';
		return $output;
	}

	function show_cart(){ //Fungsi untuk menampilkan Cart
		$output = '';
		$no = 0;
		foreach ($this->cart->contents() as $items) {
			$no++;
			$output .='
				<div class="product product-widget">

											<div class="product-body">
												<h3 class="product-price">'.number_format($items['price']).'<span class="qty"> x'.$items['qty'].'</span></h3>
												<h2 class="product-name"><a href="#">'.$items['name'].'</a></h2>
												<h2 class="product-name">'.number_format($items['subtotal']).'</h2>
											</div>

											<button id="'.$items['rowid'].'" class="hapus_cart cancel-btn" data-toggle="modal" data-target="#hapus"><i class="fa fa-trash"></i></button>

										</div>

			';
		}
		$output .= '
			<tr>
				<th colspan="3">Total :</th>
				<th colspan="2">'.' Rp '.number_format($this->cart->total()).'</th>
			</tr>
		';
		return $output;
	}

	function load_cart(){ //load data cart
		echo $this->show_cart();
	}

	function load_cart2(){ //load data cart
		echo $this->show_cart2();
	}
	function load_cart3(){ //load data cart
		echo $this->show_cart3();
	}

			function hapus_cart3(){ //fungsi untuk menghapus item cart
		$data = array(
			'rowid' => $this->input->post('row_id'),
			'qty' => 0,
		);
		$this->cart->update($data);
		echo $this->show_cart3();
	}


	function hapus_cart(){ //fungsi untuk menghapus item cart
		$data = array(
			'rowid' => $this->input->post('row_id'),
			'qty' => 0,
		);
		$this->cart->update($data);
		echo $this->show_cart();
	}
		function hapus_cart2(){ //fungsi untuk menghapus item cart
		$data = array(
			'rowid' => $this->input->post('row_id'),
			'qty' => 0,
		);
		$this->cart->update($data);
		echo $this->show_cart2();
	}

	function aksi_login(){
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$where = array(
			'username' => $username,
			'password' => $password
			);
		$cek = $this->M_data->cek_login("User",$where)->num_rows();

		if($cek > 0){

			$data_session = array(
				'nama' => $username,
				'user'=> 'okey',
				'status' => "login"
				);

			$this->session->set_userdata($data_session);

		redirect(base_url('./'));

		}else{
			echo "Username dan password salah !";
		}
	}
function daftar_user(){
	$username = $this->input->post('username');
	$nama_user = $this->input->post('nama_user');
	$alamat = $this->input->post('alamat');
	$email = $this->input->post('email');
	$tgl_lahir = $this->input->post('tgl_lahir');
	$password = $this->input->post('password');


	$data = array(
			'id_user' =>'',
			'username' => $username,
			'nama_user' => $nama_user,
			'alamat' => $alamat,
			'email_user' => $email,
			'tgl_lahir' => $tgl_lahir,
			'password' => $password,
			'foto_user' =>'chulis.jpg',
			'status' =>'0'
			);
			$this->M_data->input_data_user($data,'User');
					redirect('./');
}


	function logout(){
		$this->session->sess_destroy();
		redirect(base_url('./'));
	}

}
?>
