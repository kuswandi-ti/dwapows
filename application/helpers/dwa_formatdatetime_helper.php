<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// http://media-positive.com/tutorial/komputer/programming/laravel-programming/fungsi-php-untuk-konversi-format-tanggal-ke-indonesia.html
// http://harian.cheyuz.com/_other/format-waktu-indonesia-di-php
// http://www.w3schools.com/php/func_date_date.asp
if ( ! function_exists('convert_date'))
{
	 
	function convert_date($date, $format_type = 'format_date') { 
		$format = array(
			'Sun' => 'Minggu',
			'Mon' => 'Senin',
			'Tue' => 'Selasa',
			'Wed' => 'Rabu',
			'Thu' => 'Kamis',
			'Fri' => 'Jumat',
			'Sat' => 'Sabtu',
			'Jan' => 'Jan',
			'Feb' => 'Feb',
			'Mar' => 'Mar',
			'Apr' => 'Apr',
			'May' => 'Mei',
			'Jun' => 'Jun',
			'Jul' => 'Jul',
			'Aug' => 'Agu',
			'Sep' => 'Sep',
			'Oct' => 'Okt',
			'Nov' => 'Nov',
			'Dec' => 'Des'
		);
		
		if ($format_type == 'format_date') {
			$var_format = 'd M Y';
		} else if ($format_type == 'format_datetime') {
			$var_format = 'd M Y H:i:s';
		} else if ($format_type == 'format_time') {
			$var_format = 'H:i:s';
		} else {
			$var_format = 'd-M-Y H:i:s';
		}
		
		if ($date == '0000-00-00 00:00:00' or $date === null) {
			return '-';
		} else { 
			return strtr(date($var_format, strtotime($date)), $format);
		}
	}
}

if ( ! function_exists('nama_hari'))
{
    function nama_hari($tanggal) {
        $ubah = gmdate($tanggal, time()+60*60*8);
        $pecah = explode("-",$ubah);
        $tgl = $pecah[2];
        $bln = $pecah[1];
        $thn = $pecah[0];
		
        $nama = date("l", mktime(0,0,0,$bln,$tgl,$thn));
        $nama_hari = "";
        if($nama=="Sunday") {$nama_hari="Minggu";}
        else if($nama=="Monday") {$nama_hari="Senin";}
        else if($nama=="Tuesday") {$nama_hari="Selasa";}
        else if($nama=="Wednesday") {$nama_hari="Rabu";}
        else if($nama=="Thursday") {$nama_hari="Kamis";}
        else if($nama=="Friday") {$nama_hari="Jum'at";}
        else if($nama=="Saturday") {$nama_hari="Sabtu";}
        return $nama_hari;
    }
}

if ( ! function_exists('month_3_char')) 
{
	function month_3_char($bln) {
        switch ($bln) {
            case 1:
                return "Jan";
                break;
            case 2:
                return "Feb";
                break;
            case 3:
                return "Mar";
                break;
            case 4:
                return "Apr";
                break;
            case 5:
                return "Mei";
                break;
            case 6:
                return "Jun";
                break;
            case 7:
                return "Jul";
                break;
            case 8:
                return "Agu";
                break;
            case 9:
                return "Sep";
                break;
            case 10:
                return "Okt";
                break;
            case 11:
                return "Nov";
                break;
            case 12:
                return "Des";
                break;
        }
    }
}

if ( ! function_exists('datediff')) 
{
	/**
	* Display the difference between two dates
	* (30 years, 9 months, 25 days, 21 hours, 33 minutes, 3 seconds)
	*
	* @param  string $start starting date
	* @param  string $end=false ending date
	* @return string formatted date difference
	*
	* http://johnveldboom.com/posts/42/display-the-difference-between-two-dates-in-php
	*/
	function datediff($start,$end=false)
	{
		$return = array();
	   
		try {
			$start = new DateTime($start);
			$end = new DateTime($end);
			$form = $start->diff($end);
		} catch (Exception $e){
			return $e->getMessage();
		}
	   
		$display = array('y'=>'year',
						 'm'=>'month',
						 'd'=>'day',
						 'h'=>'hour',
						 'i'=>'minute',
						 's'=>'second');
						
		foreach($display as $key => $value) {
			if($form->$key > 0){
				$return[] = $form->$key.' '.($form->$key > 1 ? $value.'s' : $value);
			}
		}
	   
		return implode($return, ', ');
	}

	// examples
	// echo dateDiff('1982-10-14'); // 30 years, 9 months, 25 days, 21 hours, 33 minutes, 3 seconds
	// echo dateDiff('2001-09-05 08:15:05','2002-02-15 04:10:02'); // 5 months, 9 days, 19 hours, 54 minutes, 57 seconds
}

/*
if ( ! function_exists('tgl_indo'))
{
	function tgl_indo($tgl) {
        $ubah = gmdate($tgl, time()+60*60*8);
        $pecah = explode("-",$ubah);
        $tanggal = $pecah[2];
        $bulan = bulan($pecah[1]);
        $tahun = $pecah[0];
        return $tanggal.' '.$bulan.' '.$tahun;
    } 
}*/

if ( ! function_exists('bulan_num_to_char')) 
{
	function bulan_num_to_char($bln) {
        switch ($bln) {
            case 1:
                return "Januari";
                break;
            case 2:
                return "Februari";
                break;
            case 3:
                return "Maret";
                break;
            case 4:
                return "April";
                break;
            case 5:
                return "Mei";
                break;
            case 6:
                return "Juni";
                break;
            case 7:
                return "Juli";
                break;
            case 8:
                return "Agustus";
                break;
            case 9:
                return "September";
                break;
            case 10:
                return "Oktober";
                break;
            case 11:
                return "November";
                break;
            case 12:
                return "Desember";
                break;
        }
    }
}
 
/*if ( ! function_exists('hitung_mundur'))
{
    function hitung_mundur($wkt) {
        $waktu=array(   365*24*60*60    => "tahun",
                        30*24*60*60     => "bulan",
                        7*24*60*60      => "minggu",
                        24*60*60        => "hari",
                        60*60           => "jam",
                        60              => "menit",
                        1               => "detik");
						
        $hitung = strtotime(gmdate ("Y-m-d H:i:s", time () +60 * 60 * 8))-$wkt;
        $hasil = array();
        if($hitung<5) {
            $hasil = 'kurang dari 5 detik yang lalu';
        }
        else {
            $stop = 0;
            foreach($waktu as $periode => $satuan) {
                if($stop>=6 || ($stop>0 && $periode<60)) break;
                $bagi = floor($hitung/$periode);
                if($bagi > 0) {
                    $hasil[] = $bagi.' '.$satuan;
                    $hitung -= $bagi*$periode;
                    $stop++;
                }
                else if($stop>0) $stop++;
            }
            $hasil=implode(' ',$hasil).' yang lalu';
        }
        return $hasil;
    }
} */



/* End of file dwaformatdatetime_helper.php */
/* Location: ./application/helpers/dwaformatdatetime_helper.php */
