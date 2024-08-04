(function(){
	const credApp = document.querySelector('#credentials');
	const results = document.querySelector('#credentials .results');

	['credentials', 'auth', 'icons'].forEach(function(val){
		window[val] = JSON.parse(results.dataset[val]);
		results.removeAttribute('data-' + val);
	});

	const CredentialEntry = Vue.component('credential-entry', {
		props: ['entry', 'auth', 'icons',],
		template: 
	`<div class="entry">
		<div class="auth">
			<div v-for="(value, key) in entry.auth" v-bind:class="key">
				<b>{{auth[key] ? auth[key] : key}}</b>
				<input type="text" v-bind:name="key" v-bind:value="value" disabled>
				<a class="copy" title="Copy" v-html="icons.copy"></a>
			</div>
		</div>
		<div class="password">
			<div>
				<b>{{auth.password ? auth.password : 'Password'}}</b>
				<input type="password" name="password" v-bind:value="entry.password" disabled>
				<a class="copy" v-html="icons.copy"></a>
			</div>
		</div>
		<div v-if="entry['keys-notices']" class="keys-notices">
			<h4>Keys/Notices</h4>
			<ul>
				<li v-for="keyNotice in entry['keys-notices']">
					<p>{{keyNotice.item}}</p>
					<a class="copy" title="Copy" v-html="icons.copy"></a>
				</li>
			</ul>
		</div>
	</div>`,
	});

	const CredentialButtons = Vue.component('credential-buttons', {
		props: ['add-credential-label',],
		template: 
	`<div class="buttons">
		<a class="button alternative" v-on:click.stop.prevent="$emit('add-credential-popup')">{{addCredentialLabel}}</a>
	</div>`,
	});

	const resultsApp = new Vue({
		el: credApp,
		components: {
			'credential-entry': CredentialEntry,
			'credential-buttons': CredentialButtons,
		},
		data: {
			credentials: credentials,
			auth: auth,
			icons: icons,
			addCredential: {
				isActive: false,
				title: '',
				url: '',
				description: '',
			},
			editCredential: {
				isActive: false,
				id: null,
				title: '',
				url: '',
				description: '',
			},
			removeCredential: {
				isActive: false,
				id: null,
				title: '',
				url: '',
				description: '',
				entries: 0,
			},
			credentialEntry: {
				id: null,
				isActive: false,
				auth: {
					login: '',
					email: '',
					phone: '',
				},
				password: '',
				'keys-notices' : [''],
			},
		},
		methods: {
			addCredentialPopup: function(e){
				this.addCredential = {
					isActive: true,
					title: '',
					url: '',
					description: '',
				};
			},
			addCredentialSubmit: async function(e){
				try{
					const data = new FormData();
					data.append('action', 'add_credential');
					['title', 'url', 'description'].forEach(key => data.append(key, this.addCredential[key]));
					const response = await fetch(window.ajax.url, {
						method: 'POST',
						body: data,
					});
					const result = await response.json();
					if(result.error){
						alert(result.error);
					}
					else{
						this.credentials[result.id] = result;
					}
					this.closePopup();
				}
				catch(error){
					console.log(error);
				}
			},
			editCredentialPopup:function(id, e){
				this.editCredential = {
					isActive: true,
					id: id,
					title: this.credentials[id].title,
					url: this.credentials[id].url,
					description: this.credentials[id].description,
					entries: [],
				};
			},
			updateCredentialPopup:function(id, e){
				alert()
			},
			removeCredentialPopup:function(id, e){
				this.removeCredential = {
					isActive: true,
					id: id,
					title: this.credentials[id].title,
					url: this.credentials[id].url,
					description: this.credentials[id].description,
					entries: this.credentials[id]?.fields?.credentials ? this.credentials[id].fields.credentials : [],
				};
			},
			removeCredentialSubmit: async function(id, e){
				try{
					const data = new FormData();
					data.append('action', 'remove_credential');
					data.append('id', id);
					const response = await fetch(window.ajax.url, {
						method: 'POST',
						body: data,
					});
					const result = await response.json();
					if(result.error){
						alert(result.error);
					}
					else{
						delete this.credentials[result.id];
					}
					this.closePopup();
				}
				catch(error){
					console.log(error);
				}
			},
			closePopup: function(e){
				['addCredential', 'editCredential', 'removeCredential'].forEach(key => {if(this[key]) this[key].isActive = false});
			},
			credentialEntryAdd: function(id){
				this.credentialEntry = {
					id: id,
					isActive: true,
					auth: {
						login: '',
						email: '',
						phone: '',
					},
					password: '',
					'keys-notices' : [''],
				};
			},
			credentialEntryCancel: function(){
				this.credentialEntry.isActive = false;
			},
			credentialEntrySave: async function(){
				console.log(this.credentialEntry.password);
				try{
					const data = new FormData();
					data.append('action', 'update_credential_entry');
					data.append('id', this.credentialEntry.id);
					data.append('credential-entry', encodeURIComponent(JSON.stringify(this.credentialEntry)));
					const response = await fetch(window.ajax.url, {
						method: 'POST',
						body: data,
					});
					const result = await response.json();
					if(result.error){
						alert(result.error);
					}
					else{
						this.credentials[result.id].fields.credentials = result.credentials;
					}
					this.credentialEntry.isActive = false;
				}
				catch(error){
					console.log(error);
				}
			},
			credentialEntryKeynoticeChange: function(key, e){
				this.credentialEntry['keys-notices'][key] = e.target.value.trim();
			},
			credentialEntryKeynoticeRemove: function(key){
				const keysNotices = [];
				this.credentialEntry['keys-notices'].forEach((val, n) => {
					if(n != key) keysNotices.push(val);
				});
				this.credentialEntry['keys-notices'] = keysNotices;
			},
			credentialEntryKeynoticeAdd: function(){
				this.credentialEntry['keys-notices'].push('');
			},
			credentialEntryAuthInput: function(e){
				this.credentialEntry.auth[e.target.name] = e.target.value;
			},
			credentialEntryPasswordInput: function(e){
				this.credentialEntry.password = e.target.value;
			}
		}
	});
})();