<? include('topo.php'); ?>

	<div class="breadcrumb">
		<div class="central">
			<a href="./">HOME</a> &raquo; <a href="">Parceiros</a> 
		</div>
	</div>

	<div class="header-produtos fundo-cat-posto-revendedor">
		<div class="central">
	    	<h1>Parceiros</h1>
	    </div>
	</div>

	<section class="conteudo">
		<div class="central">

			<? if ($idioma == 'br'){?>

			<div class="conteudo" id="produto">
				<br>
				<p style="text-align: justify;">
				Em busca de desenvolvimento tecnológico, Arxo firma parceria com Speed Solutions. A empresa colombiana pesquisa, desenvolve e fabrica sistemas para medição e monitoramento ambiental, além de gestão de combustíveis líquidos: GLP e GNV.</p>
				<p style="text-align: justify;">
				A Speed Solutions está presente em 15 países, implantando soluções de controle, administração e gestão comercial nos processos de distribuição de combustíveis líquidos e gasosos.</p>
				<p style="text-align: justify;">
				No primeiro momento o foco da parceria será para dois produtos específicos da marca: o Speed Tank e o Speedprint Link.</p>
				<p style="text-align: justify;">
				O sistema Speed Tank é uma solução que permite monitorar e controlar o estoque de combustível líquido ou gasoso armazenado em diferentes tanques. Essa solução foi desenvolvida totalmente de acordo com as necessidades e preços de mercado. Dessa forma, evita-se oferecer serviços ou benefícios de sistema não requeridos ou desnecessários que fazem com que esse tipo de produto seja extremamente custoso e, consequentemente, pouco acessível ao cliente.<br>
				O Speed Tank permite administrar o estoque de combustível das operações a baixo custo e cumpre todos os requerimentos. É preciso ainda lembrar que esse sistema permite realizar a centralização de vários pontos, permitindo ao funcionário consultar em tempo real, via internet, o status de diferentes tanques, mesmo que estes estejam localizados a vários quilômetros de distância um do outro. Dessa forma, o sistema realiza a completa integração de informações.</p>
				<p style="text-align: justify;">
				Já o Speedprint Link é um sistema de controle industrial de fluidos, gestão de frotas e telemedição (inventário de combustível).</p>
				<p style="text-align: justify;">
				Com essa parceria a Arxo passa a ser a única distribuidora oficial da Speed Solution no Brasil, aumentando seu leque de produtos e unindo a força e a experiência de duas grandes referências de mercado.</p> 

				<div id="lista-produtos">
					<div>
						<a href="http://www.speedsol.com/" target="_blank">
							<figure><img src="/img/parceiros/logo-speed-solution.jpg"></figure>
						</a>
						<a href="https://www.cemo-group.com/" target="_blank">
							<figure><img src="/img/parceiros/logo-cemo.jpg"></figure>
						</a>
						<a href="https://www.brasilpostos.com.br/" target="_blank">
							<figure><img src="/img/parceiros/logo-brasil-postos.jpg"></figure>
						</a>
					</div>
				</div>	
			</div>

			<? } ?>

			<? if ($idioma == 'en'){?>
			<div id="lang-en">
				<h1>Partnes</h1>
				<p></p>
			</div>
			<? } ?>

			<? if ($idioma == 'es'){?>
			<div id="lang-es">

			</div>
			<? } ?>

		</div>
	</section>

<? include('rodape.php') ?>