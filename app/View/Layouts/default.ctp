<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" class="no-js" >
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, user-scalable=0">
  <meta name="theme-color" content="#e74c3c">
	<title>Rewrite Article Generator - Reword or Paraphrase Text Content</title>
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
	let nlform = new NLForm(document.getElementById( 'nl-form' ));
</script>
<script type="text/javascript">
      $('#send').click(function() {
			  let formData = new FormData();
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
			         success: function(data, status){
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
			         error : function(resultat, status, error){
			           alert('Ajax error');
			           $('#loader').hide();
			         },
			     });
			     return false;
      });
</script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-55691203-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-55691203-3');
</script>
</body>
</html>
