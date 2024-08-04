<?php
/*
Template Name: Credentials Page
Template Post Type: post, page
*/
?>

<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<h1 class="credentials-title"><?php the_title(); ?></h1>
	
	<?php the_content(); ?>

<?php endwhile; endif; ?>

<?php
if( is_user_logged_in() ) {
	$user_id = get_current_user_id();
	$user = get_userdata( $user_id );
	
	$auth = [];
	if( !empty( acf_get_field( 'credentials' )['sub_fields'] ) ) {
		foreach( acf_get_field( 'credentials' )['sub_fields'] as $sub_field ) {
			if( $sub_field['name'] != 'auth' ) continue;
			if( !empty( $sub_field['sub_fields'] ) ) foreach( $sub_field['sub_fields'] as $field ) {
				$auth[$field['name']] = $field['label'];
			}
		}
	}

	$args = [
		'author' => $user_id,
		'post_type' => 'credential',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'orderby' => 'title',
		'order' => 'ASC',
		'fields' => 'ids',
	];
	$credential_ids = get_posts( $args );
	
	$credentials = [];
	foreach( $credential_ids as $credential_id ) {
		$credentials[$credential_id] = [
			'id' => $credential_id,
			'title' => get_the_title( $credential_id ),
			'description' => get_the_content( '', '', $credential_id ),
			'fields' => get_fields( $credential_id ),
		];
	}

	$icons = [
		'copy' => file_get_contents( TEMPLATEPATH . '/svg/copy-icon.svg' ),
		'delete' => file_get_contents( TEMPLATEPATH . '/svg/delete-icon.svg' ),
		'edit' => file_get_contents( TEMPLATEPATH . '/svg/edit-icon.svg' ),
	];
	
?>
	<section id="credentials">
		<figcaption><?php printf( __( 'User: <b>%s %s</b>' ), $user->first_name, $user->last_name ); ?></figcaption>
		<form method="POST" action="<?php echo get_permalink( get_queried_object_id() ); ?>">
			<div class="filter">
				<input type="search" name="words" value="" placeholder="<?php _e( 'Search' ); ?>">
				<?php if( !empty( $auth ) ) { ?>
					<div class="fields">
						<h4><?php _e( 'Required Fields' ); ?></h4>
						<?php foreach( $auth as $name => $label ) { ?>
							<input type="checkbox" name="required_fields[]" value="<?php echo $name; ?>">
							<label><?php _e( $label ); ?></label>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
			<div class="sorting">
				<h4><?php _e( 'Sorting' ); ?></h4>
				<select name="sorting">
					<option><?php _e( 'Default' ); ?></option>
					<?php foreach( ['name' => 'Name', 'date' => 'Date'] as $key => $value ) { ?>
						<option value="<?php echo $key; ?>"><?php _e( $value ); ?></option>
					<?php } ?>
				</select>
			</div>
		</form>
		
		<credential-buttons v-on:add-credential-popup="addCredentialPopup" v-bind:add-credential-label="'<?php echo _e( '+ Add Credential' ); ?>'"></credential-buttons>

		<div
			class="results"
			<?php foreach( ['credentials', 'auth', 'icons'] as $type ) { ?>
				data-<?php echo $type; ?>='<?php echo json_encode( ${$type} ); ?>'
			<?php } ?>
		>
			<template v-if="credentials">
				<article class="credential" v-for="credential in credentials" v-bind:id="credential.id">
					<header>
						<h2>{{credential.title}}</h2>
						<div class="url" v-if="credential.fields.url">
							<a v-bind:href="credential.fields.url">{{credential.fields.url}}</a>
						</div>
						<p v-if="credential.description">{{credential.description}}</p>
						<div class="doings">
							<a class="edit" v-bind:data-credential_id="credential.id" v-on:click.stop.prevent="editCredentialPopup(credential.id)" title="<?php _e( 'Edit' ); ?>"><?php echo $icons['edit']; ?></a>
							<a class="delete" v-bind:data-credential_id="credential.id" v-on:click.stop.prevent="removeCredentialPopup(credential.id)" title="<?php _e( 'Delete' ); ?>"><?php echo $icons['delete']; ?></a>
						</div>
					</header>
					
					<div class="entries" v-if="credential.fields.credentials">
						<credential-entry
							v-for="entry in credential.fields.credentials"
							v-bind:entry="entry"
							v-bind:auth="auth"
							v-bind:icons="icons"
						></credential-entry>
					</div>

					<div class="add-entry" v-bind:class="{active:credentialEntry.isActive && credentialEntry.id == credential.id}">
						<div class="entry">
							<div class="auth">
								<div v-for="(value, key) in credentialEntry.auth" v-bind:class="key">
									<b>{{auth[key] ? auth[key] : key}}</b>
									<input type="text" v-bind:name="key" v-on:input="credentialEntryAuthInput">
								</div>
							</div>
							<div class="password">
								<div>
									<b>{{auth.password ? auth.password : 'Password'}}</b>
									<input type="password" name="password" v-bind:value="credentialEntry.password" v-on:input="credentialEntryPasswordInput">
								</div>
							</div>
							<div v-if="credentialEntry['keys-notices']" class="keys-notices">
								<h4><?php _e( 'Keys/Notices' ); ?></h4>
								<ul v-bind:data-items="credentialEntry['keys-notices'].length">
									<li v-for="(keyNotice, key) in credentialEntry['keys-notices']">
										<input type="text" name="keys-notices[]" v-bind:value="keyNotice" v-on:input="credentialEntryKeynoticeChange(key, $event)">
										<a class="remove" v-on:click.stop.prevent="credentialEntryKeynoticeRemove(key)" title="<?php _e( 'Remove the Entry' ); ?>">x</a>
										<a class="add" v-on:click.stop.prevent="credentialEntryKeynoticeAdd" title="<?php _e( 'Add the Entry' ); ?>">+</a>
									</li>
								</ul>
							</div>
						</div>

						<div class="add-button"><a v-on:click.stop.prevent="credentialEntryAdd(credential.id)" title="<?php _e( 'Add Credential Entry' ); ?>">+</a></div>
						<div class="links">
							<a class="cancel" v-on:click.stop.prevent="credentialEntryCancel"><?php _e( 'Cancel' ); ?></a>
							<a class="save" v-on:click.stop.prevent="credentialEntrySave"><?php _e( 'Save Changes' ); ?></a>
						</div>
					</div>
				</article>
			</template>
			<template v-else="credentials">
				<h4 class="error"><?php _e( 'You have not any saved credentials.' ); ?></h4>
			</template>
		</div><!-- /.results -->

		<div role="popup" v-bind:class="{active:addCredential.isActive}">
			<a class="close" v-on:click.stop.prevent="closePopup"></a>
			<div>
				<a class="close" v-on:click.stop.prevent="closePopup"></a>
				<form v-on:submit.stop.prevent="addCredentialSubmit">
					<h3><?php _e( 'Add new credential' ); ?></h3>
					<input type="text" v-model="addCredential.title" placeholder="<?php _e( 'Title' ); ?>">
					<input type="url" v-model="addCredential.url" placeholder="<?php _e( 'URL' ); ?>">
					<textarea v-model="addCredential.description" placeholder="<?php _e( 'Description' ); ?>"></textarea>
					<div class="buttons">
						<a class="button light alternative" v-on:click.stop.prevent="closePopup"><?php _e( 'Cancel' ); ?></a>
						<button type="submit" class="button" ><?php _e( 'Submit' ); ?></button>
					</div>
				</form>
			</div>
		</div>

		<div role="popup" v-bind:class="{active:removeCredential.isActive}">
			<a class="close" v-on:click.stop.prevent="closePopup"></a>
			<div>
				<a class="close" v-on:click.stop.prevent="closePopup"></a>
				<h3><?php _e( 'Remove the credential' ); ?></h3>
				<div class="line"><b><?php _e( 'Title' ); ?></b>{{removeCredential.title}}</div>
				<div class="line"><b><?php _e( 'URL' ); ?></b>{{removeCredential.url}}</div>
				<div class="line"><b><?php _e( 'Description' ); ?></b>{{removeCredential.description}}</div>
				<div class="line"><b><?php _e( 'Entries Count' ); ?></b>{{removeCredential.entries.length}}</div>
				<div class="buttons">
					<a class="button light alternative" v-on:click.stop.prevent="closePopup"><?php _e( 'Cancel' ); ?></a>
					<a class="button" v-on:click.stop.prevent="removeCredentialSubmit(removeCredential.id)"><?php _e( 'Remove' ); ?></a>
				</div>
			</div>
		</div>

		<div role="popup" v-bind:class="{active:editCredential.isActive}">
			<a class="close" v-on:click.stop.prevent="closePopup"></a>
			<div>
				<a class="close" v-on:click.stop.prevent="closePopup"></a>
				<h3><?php _e( 'Edit the credential' ); ?></h3>
				<div class="line"><b><?php _e( 'Title' ); ?></b>{{editCredential.title}}</div>
				<div class="line"><b><?php _e( 'URL' ); ?></b>{{editCredential.url}}</div>
				<div class="line"><b><?php _e( 'Description' ); ?></b>{{editCredential.description}}</div>

				<div class="buttons">
					<a class="button light alternative" v-on:click.stop.prevent="closePopup"><?php _e( 'Cancel' ); ?></a>
					<a class="button" v-on:click.stop.prevent="updateCredentialPopup(editCredential.id)"><?php _e( 'Remove' ); ?></a>
				</div>
			</div>
		</div>

		<credential-buttons v-on:add-credential-popup="addCredentialPopup" v-bind:add-credential-label="'<?php echo _e( '+ Add Credential' ); ?>'"></credential-buttons>
	</section><!--/#credentials -->
<?php } else { ?>
	<h4 class="error"><?php _e( 'You don\'t have permissions to access this credentials.' ); ?></h4>
<?php } ?>

<?php get_footer(); ?>
