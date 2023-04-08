<div class="container">


		<form class="form-horizontal" name="user_profile_form" id="user_profile_form" method="post" action="{$relative}/user/edit">
			<div class="row">			
				<div class="col-md-6">
					<fieldset class="mb-2">
						<legend>{t c='user.ACCOUNT_INF'}</legend>
						
						<div class="form-group">
							<label for="profile_username" class="control-label">{t c='global.username'}</label>
							<div>
								<input name="username" type="text" class="form-control" value="{$username}" id="profile_username" readonly />
							</div>
						</div>

						<div class="form-group">
							<label for="profile_email" class="control-label">{t c='global.email'}</label>
							<div>
								<input name="email" type="text" class="form-control" value="{$user.email}" readonly />
							</div>
						</div>
						
						<div class="form-group {if $err.password}has-error{/if}">
							<label for="profile_password" class="control-label">{t c='global.password'}</label>
							<div>
								<input name="password" type="password" class="form-control" value="" id="profile_password" />
							</div>
						</div>
						
						<div class="form-group {if $err.password}has-error{/if}">
							<label for="profile_password_confirm" class="control-label">{t c='global.password_confirm'}</label>
							<div>
								<input name="password_confirm" type="password" class="form-control" value="" id="profile_password_confirm"/>
							</div>
						</div>
						
					</fieldset>
					
					<fieldset class="mb-2">
						<legend>{t c='user.PERSONAL_INF'}</legend>
						
						<div class="form-group">
							<label for="profile_fname" class="control-label">{t c='user.first_name'}</label>
							<div>
								<input name="fname" type="text" class="form-control" value="{$user.fname}" id="profile_fname" />
							</div>
						</div>
						
						<div class="form-group">
							<label for="profile_lname" class="control-label">{t c='user.last_name'}</label>
							<div>
								<input name="lname" type="text" class="form-control" value="{$user.lname}" id="profile_lname" />
							</div>
						</div>
						
						<div class="form-group">
							<label for="profile_gender" class="control-label">{t c='global.gender'}</label>
							<div>
								<select name="gender" id="profile_gender" class="form-control">
									<option value="Male"{if $user.gender == 'Male'} selected="selected"{/if}>{t c='global.male'}</option>
									<option value="Female"{if $user.gender == 'Female'} selected="selected"{/if}>{t c='global.female'}</option>
								</select>
							</div>
						</div>

						<div class="form-group {if $err.bday}has-error{/if}">
							<label for="profile_bdate" class="control-label">{t c='user.birthday'}</label>
							<div>
								<input name="bday" id="profile_bdate" type="date" value="{$user.bdate}" class="form-control">
							</div>
						</div>

						<div class="form-group">
							<label for="profile_relation" class="control-label">{t c='user.relationship'}</label>
							<div>
								<select name="relation" id="profile_relation" class="form-control">
									<option value="">---</option>
									<option value="Single"{if $user.relation == 'Single'} selected="selected"{/if}>{t c='user.single'}</option>
									<option value="Taken"{if $user.relation == 'Taken'} selected="selected"{/if}>{t c='user.take'}</option>
									<option value="Open"{if $user.relation == 'Open'} selected="selected"{/if}>{t c='user.open'}</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label for="profile_interested" class="control-label">{t c='global.interested'}</label>
							<div>
								<select name="interested" id="profile_interested" class="form-control">
									<option value="">---</option>
									<option value="Guys"{if $user.interested == 'Guys'} selected="selected"{/if}>{t c='global.guys'}</option>
									<option value="Girls"{if $user.interested == 'Girls'} selected="selected"{/if}>{t c='global.girls'}</option>
									<option value="Guys + Girls"{if $user.interested == 'Guys + Girls'} selected="selected"{/if}>{t c='global.guys_girls'}</option>
								</select>
							</div>
						</div>						

						<div class="form-group">
							<label for="profile_website" class="control-label">{t c='global.website'}</label>
							<div>
								<input name="website" type="text" class="form-control" value="{$user.website}" id="profile_website" />
							</div>
						</div>
						
					</fieldset>					

					<fieldset class="mb-2">
						<legend>{t c='user.LOCATION_INF'}</legend>
						
						<div class="form-group">
							<label for="profile_hometown" class="control-label">{t c='global.hometown'}</label>
							<div>
								<input name="town" type="text" class="form-control" value="{$user.town}" id="profile_town" />
							</div>
						</div>
						
						<div class="form-group">
							<label for="profile_city" class="control-label">{t c='global.city'}</label>
							<div>							
								<input name="city" type="text" class="form-control" value="{$user.city}" id="profile_city" />
							</div>
						</div>
						
						<div class="form-group">
							<label for="profile_country" class="control-label">{t c='global.country'}</label>
							<div>
									
								<select name="country" id="profile_country" class="form-control">
									<option value="">Select Country</option>
									{section name=i loop=$countries}
									<option value="{$countries[i]}"{if $user.country == $countries[i]} selected="selected"{/if}>{$countries[i]}</option>
									{/section}
								</select>								
							</div>
						</div>
						
						<div class="form-group">
							<label for="profile_occupation" class="control-label">{t c='global.occupation'}</label>
							<div>
								<input name="occupation" type="text" class="form-control" value="{$user.occupation}" id="profile_occupation" />
							</div>
						</div>
						
						<div class="form-group">
							<label for="profile_company" class="control-label">{t c='global.company'}</label>
							<div>
								<input name="company" type="text" class="form-control" value="{$user.company}" id="profile_company" />
							</div>
						</div>
						
						<div class="form-group">
							<label for="profile_school" class="control-label">{t c='global.school'}</label>
							<div>
								<input name="school" type="text" class="form-control" value="{$user.school}" id="profile_school" />
							</div>
						</div>						
						
					</fieldset>	
					
				</div>

				<div class="col-md-6">
				
					<fieldset>
						<legend>{t c='user.RANDOM_INF'}</legend>

						<div class="form-group">
							<label for="profile_about" class="control-label">{t c='global.about_me'}</label>
							<div>
								<textarea name="aboutme" id="profile_about" class="form-control" rows="5">{$user.aboutme}</textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="profile_interests" class="control-label">{t c='global.here_for'}</label>
							<div>
								<textarea name="interest_hobby" id="profile_interests" class="form-control" rows="5">{$user.interest_hobby}</textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="profile_movie" class="control-label">{t c='user.favorite_sex'}</label>
							<div>
								<textarea name="fav_movie_show" id="profile_movie" class="form-control" rows="5">{$user.fav_movie_show}</textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="profile_music" class="control-label">{t c='user.favorite_sex_partner'}</label>
							<div>
								<textarea name="fav_music" id="profile_music" class="form-control" rows="5">{$user.fav_music}</textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="profile_book" class="control-label">{t c='user.my_erogenic_zones'}</label>
							<div>
								<textarea name="fav_book" id="profile_book" class="form-control" rows="5">{$user.fav_book}</textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="profile_turnon" class="control-label">{t c='user.turn_on'}</label>
							<div>
								<textarea name="turnon" id="profile_turnon" class="form-control" rows="5">{$user.turnon}</textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="profile_turnoff" class="control-label" rows="5">{t c='user.turn_off'}</label>
							<div>
								<textarea name="turnoff" id="profile_turnoff}" class="form-control" rows="5">{$user.turnoff}</textarea>
							</div>
						</div>
					</fieldset>
				</div>
				
				<div class="clearfix"></div>
				
				<div class="form-group mt-3"> 
					<div class="col-12">
						<input name="profile_submit" type="submit" value=" {t c='user.save'} " id="profile_submit" class="btn btn-primary">
					</div>
				</div>
			</div>					
		</form>

</div>