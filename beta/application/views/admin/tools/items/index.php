

<div class="col m9 s12">


	<div id="welcome message" class="section">
		<h3>Item Tools Panel</h3>
		<div class="divider"></div>
		<p class="caption">Here We Do work on Creating item options</p>
		<br>
		</p>
	</div>
	<div class="section">
        <div class="section"><?php echo validation_errors();  if(isset($slots))print_r($slots);?></div>
		<h3>Items Options</h3>

		<div class="divider"></div>
		<br> <b> Search Box </b>
		<div class="row">
			<div class="input-field col s6">
				<i class="mdi-action-search prefix"></i> <input type="text"
					name="country" id="autocomplete" placeholder="Search Item" />
				<!--<input id="icon_prefix" type="text" class="validate item-search">-->
				
			</div>
			<div class="col s6">
				<b>Create Storage Box</b>
					<div class="switch">
				    <label>
				      No
				      <input type="checkbox" id="is_storage_box">
				      <span class="lever"></span>
				      Yes
				    </label>
				  </div>
			</div>
			<div id="result"></div>
		</div>
		<div class="col offser-s1 autocomplete-suggestions" id="item-suggestions"></div>
		<form class="col s12" action="#" id="myForm">
			<div class="row">

				<div class="row">
					<div class="input-field col s3">
						<i class="mdi-image-looks-one prefix"></i> <input id="code"
							type="number" class="validate" value="0" placeholder="Item
							Code" > 
					</div>
					<div class="input-field col s3">
						<i class="mdi-image-looks-two prefix"></i> <input id="option"
							type="number" class="validate" value="0" placeholder="Item Options" >
					</div>
					<div class="input-field col s3">
						<i class="mdi-image-looks-3 prefix"></i> <input id="unique"
							type="number" class="validate" value="0" placeholder="Uniq Number" >
					</div>
					<div class="input-field col s3">
						<i class="mdi-image-looks-4 prefix"></i> <input id="slot"
							type="number" class="validate" value="0" placeholder="Slot" >
					</div>
				</div>

			</div>
			<div class="row" id="item_options_calculation">

				<div class="col s6">

					<div class="input-field">
						<input id="level" type="number" class="validate" value="1" max="15"
							min="1" placeholder="Level">
					</div>
					<p>
						<input type="checkbox" id="blessing" /> <label for="blessing">Blessings</label>

					</p>
					<p>
						<input type="checkbox" id="additional" /> <label for="additional">Additional
							Attack</label>
					</p>
					<p>
						<input type="checkbox" id="unidentified" /> <label
							for="unidentified">Un Identified</label>

					</p>
					<br> <label>Mounting Select</label> <select id="mounting">
						<option value="0" selected>Choose your option</option>
						<option value="1">10 %</option>
						<option value="2">20 %</option>
						<option value="3">30 %</option>
					</select> <br>


				</div>
				<div class="col s6">
					<div class="row">
						<div class="input-field col s6">
							<input id="type" type="text" class="validate" value="0"> <label>Item
								Type</label>

						</div>
						<div class="input-field col s6">
							<input id="class" type="text" class="validate" value="0"> <label>Item
								Class</label>

						</div>
					</div>
					<div class="input-field">
						<input id="blue" type="number" class="validate" value="0" max="0"
							min="0" placeholder="Max Blue" >
					</div>
					<div class="input-field">
						<input id="red" type="number" class="validate" value="0" max="0"
							min="0" placeholder="Max Red" >
					</div>
					<div class="input-field">
						<input id="yellow" type="number" class="validate" value="0" max="0"
							min="0" placeholder="Max Yellow" >
					</div>



				</div>

			</div>
			<div class="section" id="storage_box_calculation" style="display:none">
			<div class="row">
			<div class="input-field col s6">
						<i class="mdi-image-looks-one prefix"></i> <input id="count"
							type="text" class="validate" value="1"> <label for="icon_prefix">Item
							Count</label>
					</div>
					<div class="col s6"></div>
				</div>
			</div>
			<div class="section">
				<div class="row">
					<div class="input-field col s6">
						<i class="mdi-action-assignment prefix"></i> <input id="final"
							type="text" class="validate" value="0"> <label for="icon_prefix">Final
							Code</label>
					</div>
				</div>
			</div>

			<div class="section form-bottom">
				<a class="grey darken-4 waves-effect waves-light btn calculate"><i
					class="mdi-action-view-stream left"></i>Calculate</a>
			</div>

		</form>
	</div>
	<div class="section">
		<form class="col s12" action=" " method="post">
			<h3>Select Character</h3>

			<div class="divider"></div>
			<br>

			<b> Select Character </b>
			<div class="row">
				<div class="input-field col s6">
					<i class="mdi-action-search prefix"></i> <input type="text"
						name="character" id="characterName" />
					<!--<input id="icon_prefix" type="text" class="validate item-search">-->
					<label for="icon_prefix">--</label>
				</div>
				<div class="input-field col s6">
					<i class="mdi-navigation-arrow-forward prefix"></i> <input
						type="text" name="item_code" id="item" value="0" />
					<!--<input id="icon_prefix" type="text" class="validate item-search">-->
					<label for="icon_prefix">Item Code</label>
				</div>

				<div id="result"></div>
			</div>

			<div class="col offser-s1 autocomplete-suggestions" id="character-suggestions"></div>
			<button class="btn waves-effect waves-light" type="submit"
				name="action">
				Submit <i class="mdi-content-send right"></i>
			</button>
		</form>

	</div>


	<!--Do Not Touch anny thing below here-->
</div>

</div>


</div>
</div>



</div>
</div>

</main>