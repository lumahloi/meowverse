<form name="cadastro" method="post" action="cadastro1.php" onsubmit="return valida_form(this);">
	<div id="caixa_cad">
	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
		    <tr>
				<td width="45%" valign="top">
					<h6>Dados pessoais</h6>
					<p><label>Nome completo:</label><input name="txtnome" type="text" class="caixa_texto" id="txtnome" size="35" maxlength="60" value="<?PHP print $txtnome; ?>" />*</p>

					<p><label><strong>(1)</strong> CPF:</label><input name="txtcpf" type="text" class="caixa_texto" id="txtcpf" size="15" maxlength="11" value="<?PHP print $txtcpf; ?>" /> * (somente números)</p>

					<p><label>RG:</label><input name="txtrg" type="text" class="caixa_texto" id="txtrg" size="15" maxlength="14" value="<?PHP print $txtrg; ?>" /></p>

					<p><label>Sexo:</label><select name="txtsexo" id="txtsexo">
						<?PHP
							if ($txtsexo == "F") {
								$itens_sexo = $itens_sexo . "<option value='M'>Masculino</option><br /> ";
								$itens_sexo = $itens_sexo . "<option value='F' selected='selected'>Feminino</option><br /> ";
							} else {
								$itens_sexo = $itens_sexo . "<option value='M' selected='selected'>Masculino</option><br /> ";
								$itens_sexo = $itens_sexo . "<option value='F'>Feminino</option><br /> ";
							}
							print $itens_sexo;
						?>
					</select> *</p>

					<p><label>E-mail:</label><input name="txtemail_1" type="text" class="caixa_texto" size="35" maxlength="60" value="<?PHP print $txtemail_1; ?>" />*</p>

					<p><label><strong>(2)</strong> Confirme o e-mail:</label><input name="txtemail_2" type="text" class="caixa_texto" size="35" maxlength="60" value="<?PHP print $txtemail_2; ?>" />*</p>

					<p><label>Senha:</label><input name="txtsenha_1" type="text" class="caixa_texto" id="txtsenha_1" size="10" maxlength="10" value="<?PHP print $txtsenha_1; ?>" />* (mínimo de 5 caracteres)</p>

					<p><label>Confirme a senha:</label><input name="txtsenha_2" type="text" class="caixa_texto" id="txtsenha_2" size="10" maxlength="10" value="<?PHP print $txtsenha_2; ?>" />*</p>
				</td>

				<td width="10%">&nbsp;</td>

			    <td width="45%" valign="top">
					<h6>Endereço de entrega</h6>
					<p><label>Logradouro:</label><input name="txtend_nome" type="text" class="caixa_texto" id="txtend_nome" size="35" maxlength="60" value="<?PHP print $txtend_nome; ?>" />*</p>

					<p><label>Número:</label><input name="txtend_num" type="text" class="caixa_texto" id="txtend_num" size="10" maxlength="10" value="<?PHP print $txtend_num; ?>" /> * </p>

					<p><label>Complemento:</label><input name="txtend_comp" type="text" class="caixa_texto" id="txtend_comp" size="20" maxlength="20" value="<?PHP print $txtend_comp; ?>" /></p>

					<p><label>CEP:</label><input name="txtcep" type="text" class="caixa_texto" id="txtcep" size="15" maxlength="8" value="<?PHP print $txtcep; ?>" /> *</p>

					<p><label>Bairro:</label><input name="txtbairro" type="text" class="caixa_texto" id="txtbairro" size="35" maxlength="40" value="<?PHP print $txtbairro; ?>" />*</p>

					<p><label>Cidade:</label><input name="txtcidade" type="text" class="caixa_texto" id="txtcidade" size="35" maxlength="40" value="<?PHP print $txtcidade; ?>" />*</p>

					<p><label>Unidade federativa:</label><select name="txtuf" class="formulario_cadastro2">
						<?PHP
							// Carrega combo de unidades federativas
							$itens_uf = "<option value='0'>-- Selecione um estado</option><br /> ";
							$sql_uf = "SELECT * FROM tb_estados ";
						    $rs_uf = mysqli_query($conexao, $sql_uf);
							while ($reg_uf = mysqli_fetch_array($rs_uf)) {
								if ($txtuf == $reg_uf['uf']) {
									$itens_uf = $itens_uf . "<option value='" . $reg_uf['uf'] . "' selected='selected'>" . $reg_uf['nome'] . "</option><br /> ";
								} else {
									$itens_uf = $itens_uf . "<option value='" . $reg_uf['uf'] . "'>" . $reg_uf['nome'] . "</option><br /> ";
								}
							}
							print $itens_uf;
						?>
					</select> *</p>
				</td>
			</tr>
		</table>
		<p align="right">
			<input type="hidden" name="verifica_erro" value="S" />
			<input type="image" name="imageField" src="imagens/btn_continuar.gif" />
		</p>
	</div>
</form>