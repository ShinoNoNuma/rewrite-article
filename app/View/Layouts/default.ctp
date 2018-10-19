<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
	<?php echo $this->Html->charset(); ?>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
	<title>
		<?php echo $this->fetch('title'); ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		//echo $this->Html->css('cake.generic');
		echo $this->Html->css(array('flexboxgrid.min','default','component')); 
		echo $this->Html->script(array('modernizr.custom'));  
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body class="nl-blurred">
<?php echo $this->Flash->render(); 
			echo $this->fetch('content'); 
			echo $this->element('sql_dump');
	 		echo $this->Html->script(array('nlform','jquery-3.2.1.min')); 
?>
<script>
	var nlform = new NLForm(document.getElementById( 'nl-form' ));
</script>
<script type="text/javascript">
      $('#send').click(function() {
			  var formData = new FormData();
			  formData.append('text', $('#text').val());
			  formData.append('level', $('#rephraseLevel').val());
			  formData.append('alternate', $('#rephraseAlternate').val());
			     $('#loader').fadeIn(1200);
			  $.ajax({
			    type: "post",
			    url:"<?php echo $this->Html->url(array('controller' => 'pages','action' => 'home'));?>",
			    data: formData,
			       dataType : "json",
			       processData: false,
			       contentType: false,
			         success: function(data, statut){
			           if(data.response == 'error'){
			             $('#nl-form').empty();
			             $('#nl-form').html(data.message);
			              $('#loader').hide();
			           }else{
			             $('#nl-form').empty();
			             $('#nl-form').html(data.rewriteArticle);
			             $('#loader').hide();
			           }
			         },
			         error : function(resultat, statut, erreur){
			           alert('Ajax error');
			           $('#loader').hide();
			         },
			     });
			     return false;
      });
</script>
</body>
</html>
