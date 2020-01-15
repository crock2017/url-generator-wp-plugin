<?php
// ===== front template url_generator plugin ==========
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<iframe id="urlG_content"  style="display:none;"></iframe>

<div class=" main_generator container">
	<div class="row">
			<div class="form-group col-md-2">
				<label class="lbl" for="url_link">Ссылка</label>
			</div>
			  <div class="form-group col-md-6">
				<input name="url_link" type="text" class="" id="url_link"  placeholder="">
			  </div>
			<div class="form-group col-md-4">
				<button class="btn btn-primary" id="url_btn">Данные</button>
		  	</div>
			
		  
		
	</div>
	<div class="row">
		  <div class="form-group col-md-8">
			<div >
				<div class="row">
					<div class="col-md-3">
						<div class="post_data">Title: </div>
					</div>
				<div id="urlG_info_title" class="col-md-9 urlG_info"></div>
				</div>
				<div class="row">
					<div class="col-md-3">
						<div class="post_data">Description: </div>
					</div>
				<div id="urlG_info_desc" class="col-md-9 urlG_info"></div>
				</div>
				<div class="row">
					<div class="col-md-3">
						<div class="post_data">H1: </div>
					</div>
				<div id="urlG_info_h1" class="col-md-9 urlG_info"></div>
				</div>
			  </div>
		  </div>
	</div>
	<div class="row">
		  <div class="form-group col-md-8">
			<label for="template">Шаблон</label>
			<textarea maxlength="64000" rows="20" name="template" type="" class="" id="template"  ></textarea>
			<button class="btn btn-primary" id="create_btn">Создать</button>
		  </div>
		  <div class="form-group col-md-4">
			<div class="result_data">
			  	<div id="urlG_info_smbl" class="urlG_tips">Кол-во символов: <span>0</span></div>
				<div class="urlG_tips">
					<p>Длина постов: </p>
					<p>Интсаграм: 170</p>
					<p>Фейсбук: 80-120</p>
					<p>Вконтакте: 320</p>
					<p>Одноклассники: 290</p>
					<p>Твиттер: 250</p>
				</div>
			</div>
		  </div>
	</div>
	<div class="row">
		  <div class="form-group col-md-8">
			<label for="result">Результат</label>
			<textarea rows="10" name="result" type="" class="" id="result"  ></textarea>
			<button class="btn btn-primary" id="copy_result_btn">Скопировать</button>
		  </div>
	</div>
	<div class="row">
		  <div class="form-group socbtn col-md-2">
			<button type="button" class="btn btn-primary btn-block" id="">URL</button>
		  </div>
		  <div class="form-group socbtn col-md-2">
			<button class="btn btn-primary btn-block" id="">Вконтакте</button>
		  </div>
		  <div class="form-group socbtn col-md-2">
			<button class="btn btn-primary btn-block" id="">OK</button>
		  </div>
		  <div class="form-group socbtn col-md-2">
			<button class="btn btn-primary btn-block" id="">FaceBook</button>
		  </div>
		  <div class="form-group socbtn col-md-2">
			<button class="btn btn-primary btn-block" id="">Instagram</button>
		  </div>
		  <div class="form-group socbtn col-md-2">
			<button class="btn btn-primary btn-block" id="">Twitter</button>
		  </div>
	</div>
	<div class="row">
		  <div class="form-group col-md-8">
			<textarea rows="10" name="total" type="" class="" id="total"  ></textarea>
			<button class="btn btn-primary" id="copy_total_btn">Скопировать</button>
		</div>
	</div>
	<div class='ajax_loader'></div>
	</div>