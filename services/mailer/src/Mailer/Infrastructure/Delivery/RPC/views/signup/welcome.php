<html>
<head>
	<title>Newsletter</title>

	<style>
		body {
			margin: 0;
			padding: 0;
		}

		.block {}
		.block--inline {
			display: inline-block;
			vertical-align: top;
		}


		@media screen and (max-width: 600px) {
			table {
				max-width: 100% !important;
			}
		}
	</style>
</head>

<body>
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<!--[if (MSO|IE)]>
			<table width="600" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: auto;">
				<tr>
					<td>
			<![endif]-->
			<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: auto;">
				<tr>
					<td valign="top" style="font-size: 0; text-align: center;">
						<div class="block--inline">
							<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="devicewidth" style="max-width: 600px;">
								<tr>
									<td valign="middle" align="left" style="padding: 40px 10px; color: #252527; font: 14px serif; font-style: italic; text-align: left;">
										<h1>Hi <?= $displayName; ?>!</h1>
										<p>Welcome to the mailing list.</p>
									</td>
								</tr>

							</table>
						</div>
					</td>
					<td valign="top" align="left" width="100%">
				<tr>
				</tr>
				</td>
				</tr>
			</table>
			<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: auto;">
				<tr>
					<td align="center" valign="top" width="50%" class="templateColumnContainer">
						<table border="0" cellpadding="10" cellspacing="0" width="100%">
							<tr>
								<td valign="top" class="leftColumnContent">
									<p style="color: #252527; font: 14px serif; font-style: italic; text-align: left;">
										Created by:
									</p>
									<a href="http://cableandcode.co.uk/" style="border: 0;">
										<img src="" alt="Cable and Code" width="73" height="64" style="border: 0;">
									</a>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<!--[if (MSO|IE)]>
			</td>
			</tr>
			</table>
			<![endif]-->
		</td>
	</tr>
</table>
</body>
</html>

