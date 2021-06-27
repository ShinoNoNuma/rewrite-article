<div class="container">
   <!-- Top Navigation -->
   <header>
      <h1>Rewrite Article Generator <span>v 0.12</span></h1>
   </header>
   <a href="https://github.com/Naqwada/Rewrite-Article-Generator" title="GitHub Source Code" target="_blank">
   <img alt="GitHub Logomark" src="https://github.githubassets.com/images/modules/logos_page/GitHub-Mark.png" width="32"></a>
   <div class="row">
      <div class="col-md-6">
         <?php echo $this->Form->create('rephrase', array('class' => 'nl-form')); ?>
         <?php echo $this->Form->textarea('text',array('class' => 'form-control', 'rows' => 14, 'placeholder' => 'Put your text here','id' => 'text')); ?>
         <?php   echo $this->Form->input('level', array(
            'options' => array(4 => 'High', 5 => 'Normal', 6 => 'Soft'),
            'label' => 'Rewite Level: ',
            'default' => 4
            ));
            echo $this->Form->input('alternate', array(
            'options' => array(0 => 'Disable', 1 => 'Enable'),
            'label' => 'Alternate Rewite (ALPHA): ',
            'default' => 0
            ));
            ?>
         <div class="nl-submit-wrap">
            <div id="charNum"></div>
            <?php echo $this->Form->button(__('Rewrite!'), array('type' => 'button','class' => 'nl-submit text-right','id' => 'send')); ?>
         </div>
         <?php echo $this->Form->end();?>
      </div>
      <div class="col-md-6" style="border:1px black dashed;">
         <form id="nl-form" class="nl-form">
            <div class="nl-overlay"></div>
         </form>
      </div>
      <div id="loader" style="z-index: 10; position: absolute;width:100%;height:100%;top:0%;bottom: 0%;left:0%;right:0%;background-color: rgba(0, 0, 255, 0.5);display: none;">
         <div class="lds-css ng-scope" style="position: absolute;top: 50%;bottom: 50%;left: 43%;right: 50%;width:100%;height:100%;">
            <div class="lds-pacman">
               <div>
                  <div></div>
                  <div></div>
                  <div></div>
               </div>
               <div>
                  <div></div>
                  <div></div>
               </div>
            </div>
            <h1>Text analyze. Be patient..</h1>
            <style type="text/css">@keyframes lds-pacman-1 {
               0% {
               -webkit-transform: rotate(0deg);
               transform: rotate(0deg);
               }
               50% {
               -webkit-transform: rotate(-45deg);
               transform: rotate(-45deg);
               }
               100% {
               -webkit-transform: rotate(0deg);
               transform: rotate(0deg);
               }
               }
               @-webkit-keyframes lds-pacman-1 {
               0% {
               -webkit-transform: rotate(0deg);
               transform: rotate(0deg);
               }
               50% {
               -webkit-transform: rotate(-45deg);
               transform: rotate(-45deg);
               }
               100% {
               -webkit-transform: rotate(0deg);
               transform: rotate(0deg);
               }
               }
               @keyframes lds-pacman-2 {
               0% {
               -webkit-transform: rotate(180deg);
               transform: rotate(180deg);
               }
               50% {
               -webkit-transform: rotate(225deg);
               transform: rotate(225deg);
               }
               100% {
               -webkit-transform: rotate(180deg);
               transform: rotate(180deg);
               }
               }
               @-webkit-keyframes lds-pacman-2 {
               0% {
               -webkit-transform: rotate(180deg);
               transform: rotate(180deg);
               }
               50% {
               -webkit-transform: rotate(225deg);
               transform: rotate(225deg);
               }
               100% {
               -webkit-transform: rotate(180deg);
               transform: rotate(180deg);
               }
               }
               @keyframes lds-pacman-3 {
               0% {
               -webkit-transform: translate(190px, 0);
               transform: translate(190px, 0);
               opacity: 0;
               }
               20% {
               opacity: 1;
               }
               100% {
               -webkit-transform: translate(70px, 0);
               transform: translate(70px, 0);
               opacity: 1;
               }
               }
               @-webkit-keyframes lds-pacman-3 {
               0% {
               -webkit-transform: translate(190px, 0);
               transform: translate(190px, 0);
               opacity: 0;
               }
               20% {
               opacity: 1;
               }
               100% {
               -webkit-transform: translate(70px, 0);
               transform: translate(70px, 0);
               opacity: 1;
               }
               }
               .lds-pacman {
               position: relative;
               }
               .lds-pacman > div:nth-child(2) div {
               position: absolute;
               top: 40px;
               left: 40px;
               width: 120px;
               height: 60px;
               border-radius: 120px 120px 0 0;
               background: #f6b93b;
               -webkit-animation: lds-pacman-1 1s linear infinite;
               animation: lds-pacman-1 1s linear infinite;
               -webkit-transform-origin: 60px 60px;
               transform-origin: 60px 60px;
               }
               .lds-pacman > div:nth-child(2) div:nth-child(2) {
               -webkit-animation: lds-pacman-2 1s linear infinite;
               animation: lds-pacman-2 1s linear infinite;
               }
               .lds-pacman > div:nth-child(1) div {
               position: absolute;
               top: 92px;
               left: -8px;
               width: 16px;
               height: 16px;
               border-radius: 50%;
               background: #f8c291;
               -webkit-animation: lds-pacman-3 1s linear infinite;
               animation: lds-pacman-3 1s linear infinite;
               }
               .lds-pacman > div:nth-child(1) div:nth-child(1) {
               -webkit-animation-delay: -0.67s;
               animation-delay: -0.67s;
               }
               .lds-pacman > div:nth-child(1) div:nth-child(2) {
               -webkit-animation-delay: -0.33s;
               animation-delay: -0.33s;
               }
               .lds-pacman > div:nth-child(1) div:nth-child(3) {
               -webkit-animation-delay: 0s;
               animation-delay: 0s;
               }
               .lds-pacman {
               width: 200px !important;
               height: 200px !important;
               -webkit-transform: translate(-100px, -100px) scale(1) translate(100px, 100px);
               transform: translate(-100px, -100px) scale(1) translate(100px, 100px);
               }
            </style>
         </div>
      </div>
   </div>
</div>