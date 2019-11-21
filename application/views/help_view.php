<!-- http://www.paulund.co.uk/playground/demo/jquery_internal_animation_scrolling/#services -->

<style>

</style>

<br />

<ul id="crumbs">
	<li><a href="<?= base_url('menu'); ?>">Menu</a></li>
	<li><b>Help</b></li>
</ul>

<br />

<div id="help">
	<ul>	
		<li><h4><a href="#tentang">1. Tentang Aplikasi</a></h4></li>
		<li><h4><a href="#resources">2. Resources</a></h4></li>
		<li><h4><a href="#mulai">3. Memulai Aplikasi</a></h4>
			<ol>	
				<li><h4><a href="#login">3.1. Login</a></h4></li>	
				<li><h4><a href="#menu">3.2. Pilih Menu</a></h4></li>
			</ol>
		</li>
		<li><h4><a href="#document">4. Dokumen</a></h4></li>
		<li><h4><a href="#logout">5. Mengakhiri Aplikasi</a></h4></li>	
		<li><h4><a href="#support">6. Support</a></h4></li>	
	</ul>
	<br />
	<br />
	<div id="tentang">
		<h2><img src="assets/images/help/tentang.png"><em>&nbsp;Tentang Aplikasi</em></h2>
		<a href="#help">Back To Top</a>
		<hr />
		<p align="justify">
			<b>Cycle Ordering DWA</b> adalah sistem yang dibuat untuk mempermudah distribusi dokumen dari PT. Dasa Windu Agung (DWA)
			kepada supplier.
			Dengan menggunakan sistem ini, diharapkan dapat memberi keuntungan dan kemudahan untuk kedua belah pihak, baik
			PT. DWA sendiri terlebih lagi untuk pihak supplier. 			
		</p>
		<br />
		<p align="justify">
			Diantara keuntungan dan kemudahan tersebut antara lain :
			<ol>
				<li>1. Meminimalkan <em>miscommunication</em> antara pihak PT. DWA dengan Supplier mengenai dokumen order.</li>
				<li>2. Mempercepat pendistribusian dokumen order.</li>
				<li>3. Update status dokumen order secara <em>realtime</em> dan berkala, 
					   sehingga Supplier bisa secara langsung memantau status dokumen order.</li>
				<li>4. Supplier bisa secara mandiri me-<em>manage</em> dokumen order.</li>
			</ol>
		</p>
	</div>
	<br />
	<br />
	<div id="resources">
		<h2><img src="assets/images/help/resources.png"><em>&nbsp;Resources</em></h2>
		<a href="#help">Back To Top</a>
		<hr />
		<img src="assets/images/help/mozilla_firefox.png">
		<img src="assets/images/help/google_chrome.png">
	</div>
	<br />
	<br />
	<div id="mulai">
		<h2><img src="assets/images/help/start.png"><em>&nbsp;Memulai Aplikasi</em></h2>
		<a href="#help">Back To Top</a>
		<hr />
		<div id="login">
			<ol>
				<h3><img src="assets/images/help/key.png">&nbsp;Login</h3>
				<a href="#help">Back To Top</a>
				<li>
					<p style="text-indent: 2em;">
						Sebelum memulai aplikasi, user / supplier diharuskan untuk Login terlebih dahulu. User Id dan Password untuk login
						sebelumnya sudah dikonfirmasi dengan pihak PT. DWA.
					</p>
					<img src="assets/images/help/login-all.png" alt="login" height="50%" width="80%">
				</li>
			</ol>
		</div>
		<div id="menu">			
			<ol>
				<h3><img src="assets/images/help/menu.png">&nbsp;Pilih Menu</h3>
				<a href="#help">Back To Top</a>
				<li>
					<p style="text-indent: 2em;">
						Setelah berhasil login, user / supplier memilih menu sesuai dokumen yang akan diproses.
					</p>
					<img src="assets/images/help/menushow.png" alt="menu" height="50%" width="50%">
				</li>
			</ol>
		</div>
	</div>
	<br />
	<br />
	<div id="document">
		<h2><img src="assets/images/help/document.png"><em>&nbsp;Dokumen</em></h2>
		<a href="#help">Back To Top</a>
		<hr />
		Untuk setiap dokumen, tersedia <b>STATUS DOKUMEN</b> sebagai tanda dari posisi dokumen.<br />
		Adapun <em>status dokumen</em> untuk FO, PLO, dan DI adalah :
		<ol>
			<li><b>- RELEASED</b> (Dokumen baru diterbitkan oleh PT. DWA),</li>
			<li><b>- RECEIVED</b> (Dokumen sudah diterima oleh supplier), 
			<li><b>- REVISI</b> (Dokumen yang mengalami revisi karena ketidaksesuaian antara pihak PT. DWA dan Supplier), 
			<li><b>- REJECTED</b> (Dokumen yang dikembalikan oleh Supplier karena ketidaksesuaian antara pihak PT. DWA dan Supplier).
		</ol>
		Sedangkan <em>status dokumen</em> untuk RECEIVING adalah :
		<ol>
			<li><b>- OPENED</b> (Dokumen baru diterbitkan tetapi barang belum diterima sama sekali oleh PT. DWA),</li>
			<li><b>- CLOSED</b> (PT. DWA sudah terima barang sepenuhnya dari Supplier atas dokumen yang bersangkutan), 
			<li><b>- OUTSTANDING</b> (PT. DWA baru terima barang sebagian dari Supplier atas dokumen yang bersangkutan), 
			<li><b>- INVOICING</b> (PT. DWA sudah terima barang sepenuhnya dari Supplier atas dokumen yang bersangkutan dan sudah siap dibuatkan INVOICE).
		</ol>
		<p style="text-indent: 2em;">
			Screenshoot contoh status dari ketiga dokumen tersebut.
		</p>
		<img src="assets/images/help/status-dokumen-foplodi.png" alt="foplodi" height="50%" width="80%">
	</div>
	<br />
	<br />
	<div id="logout">
		<h2><img src="assets/images/help/exit.png"><em>&nbsp;Mengakhiri Aplikasi</em></h2>
		<a href="#help">Back To Top</a>
		<hr />
		Klik <b>Logout</b> untuk keluar dari aplikasi.
		<p>
			<font color="red">
				<h3>Untuk alasan keamanan, setiap selesai melakukan interaksi dengan sistem ini 
				usahakan untuk melakukan proses logout.</h3>
			</font>			
		</p>
	</div>
	<br />
	<br />
	<div id="support">
		<h2><img src="assets/images/help/support.png"><em>&nbsp;Support</em></h2>
		<a href="#help">Back To Top</a>
		<hr />
		Silahkan email ke <a href="mailto:mis@dwa.co.id?subject=Cycle Ordering DWA">mis@dwa.co.id</a> atau menghubungi (021) - 8255081 / 52 
	</div>
</div>

<script type="text/javascript" src="assets/plugins/jquery/jquery-1.11.1.min.js"></script>

<script>
	$(document).ready(function() {
		$('a[href^="#"]').on('click',function (e) {
			e.preventDefault();

			var target = this.hash,
			$target = $(target);

			$('html, body').stop().animate({
				'scrollTop': $target.offset().top
			}, 900, 'swing', function () {
				window.location.hash = target;
			});
		});		
		
		$(document).bind("contextmenu",function(e){
			return false;
		});
	});
	
	$(window).load(function() { 
		$("#loading").fadeOut("slow"); 
	});
</script>