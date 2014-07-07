<?php
	class StatRow {
		public $id;
		public $gp;
		public $w;
		public $wpgp;
		public $d;
		public $l;
		public $gf;
		public $ga;
		public $gd;
		
		public function __construct($id, $gp, $w, $wpgp, $d, $l, $gf, $ga, $gd) {
			$this->id = $id;
			$this->gp = $gp;
			$this->w = $w;
			$this->wpgp = $wpgp;
			$this->d = $d;
			$this->l = $l;
			$this->gf = $gf;
			$this->ga = $ga;
			$this->gd = $gd;
		}
		
	}
?>