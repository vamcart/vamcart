<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
   
	class AppError extends ErrorHandler {

		function error($params) {
			$this->controller->layout = "default";
			parent::error($params);
		}

		function error404($params) {
			$this->controller->layout = "default";
			parent::error404($params);
		}

		function missingController($params) {
			$this->controller->layout = "default";
			parent::missingController($params);
		}

		function missingAction($params) {
			$this->controller->layout = "default";
			parent::missingAction($params);
		}

		function privateAction($params) {
			$this->controller->layout = "default";
			parent::privateAction($params);
		}

		function missingTable($params) {
			$this->controller->layout = "default";
			parent::missingTable($params);
		}

		function missingDatabase($params) {
			$this->controller->layout = "default";
			parent::missingDatabase($params);
		}

		function missingView($params) {
			$this->controller->layout = "default";
			parent::missingView($params);
		}

		function missingLayout($params) {
			$this->controller->layout = "default";
			parent::missingLayout($params);
		}

		function missingConnection($params) {
			$this->controller->layout = "default";
			parent::missingConnection($params);
		}

		function missingHelperFile($params) {
			$this->controller->layout = "default";
			parent::missingHelperFile($params);
		}

		function missingHelperClass($params) {
			$this->controller->layout = "default";
			parent::missingHelperClass($params);
		}

		function missingComponentFile($params) {
			$this->controller->layout = "default";
			parent::missingComponentFile($params);
		}

		function missingComponentClass($params) {
			$this->controller->layout = "default";
			parent::missingComponentClass($params);
		}

		function missingModel($params) {
			$this->controller->layout = "default";
			parent::missingModel($params);
		}

	} 
?>