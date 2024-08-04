<?php 
if( $block['mode'] == 'preview' ) return;

$field = get_field( 'chat-gpt' );
?>

<form method="post" action="">
	<div class="form-group">
		<label for="email">Your Question Here:</label>
		
		<textarea class="form-control" id="question" name="question" rows="5"></textarea>
	</div>					
	<button type="submit" class="btn btn-primary">Get Answer</button>
</form>	
<?php
if(!empty($_POST["question"]) && $_POST['question']) {
	
	
			
?>	
	<span class="text-danger font-weight-bold">Question : </span>
	<span class="font-weight-normal" style="margin-left:10px;"><?php echo ucfirst($_POST['question']); ?><span><br>
	<span class="text-success font-weight-bold">Answer : </span>
	<span class="font-weight-normal" style="margin-left:10px;">
	<?php 
	$ch = curl_init();
	$headers  = [
		'Accept: application/json',
		'Content-Type: application/json',
		'Authorization: Bearer ' . $field['api_key'] . '',
	];
	print_r( $headers );

	$postData = [
		'model' => $field['model'],
		'prompt' => str_replace('"', '', $_POST['question']),
		'temperature' => $field['temperature'],
		'max_tokens' => $field['max_tokens'],
		'top_p' => $field['top_p'],
		'frequency_penalty' => $field['frequency_penalty'],
		'presence_penalty' => $field['presence_penalty'],
		'stop' => '[" Human:", " AI:"]',
	];
	curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/completions');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
	$result = curl_exec($ch);
	$decoded_json = json_decode($result, true);
	print_r($result);
	echo ($decoded_json['choices'][0]['text']); 
	?>
	<span>		
<?php
}			
?>