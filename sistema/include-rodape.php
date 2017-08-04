	</div>
	<div id="rodape" class="<?=$page?>">
		<span class="suporte">Suporte: <a href="mailto:contato@dataprisma.com.br">contato@dataprisma.com.br</a> | 47 3035-1868 | <a href="http://www.dataprisma.com.br">www.dataprisma.com.br</a></span>
		<? if($page != 'index'){ ?><span class="voltar-topo"><img src="../img/sistema/voltar-topo.png" alt="voltar ao topo" class="vimg" /></span><? } ?>
	</div>
    
	<script src="../scripts/file-upload/jquery.ui.widget.js"></script>

	<script src="../scripts/file-upload/tmpl.min.js"></script>
    <script src="../scripts/file-upload/load-image.min.js"></script>
    <script src="../scripts/file-upload/canvas-to-blob.min.js"></script>
    <script src="../scripts/file-upload/bootstrap.min.js"></script>
    <script src="../scripts/file-upload/jquery.blueimp-gallery.min.js"></script>

	<script src="../scripts/file-upload/jquery.iframe-transport.js"></script>
	<script src="../scripts/file-upload/jquery.fileupload.js"></script>
	<script src="../scripts/file-upload/jquery.fileupload-process.js"></script>
	<script src="../scripts/file-upload/jquery.fileupload-image.js"></script>
	<script src="../scripts/file-upload/jquery.fileupload-audio.js"></script>
	<script src="../scripts/file-upload/jquery.fileupload-video.js"></script>
	<script src="../scripts/file-upload/jquery.fileupload-validate.js"></script>
	<script src="../scripts/file-upload/jquery.fileupload-ui.js"></script>
	<script src="../scripts/file-upload/main.js"></script>

</body>
</html>
<? ob_end_flush() ?>