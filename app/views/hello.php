<!doctype html>
<html lang="zh-hant">
	<head>
		<meta charset="UTF-8">
		<title>UNCOVER</title>
		<link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,300' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Raleway:400,300' rel='stylesheet' type='text/css'>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

		<style>
			body {
				margin:0;
				text-align: center;
				font-family:'Raleway';
				font-weight: 400;
				background-color: #1a1a1a;
				color: #fff;
			}

			h1 {
				margin-top: 12%;
				font-weight: 300;
				font-size: 54px;
				letter-spacing: 2px;
				line-height: 1em;
			}

			#search {
				font-size: 32px;
				border: none;
				border-bottom: 2px solid #ccc;
				background-color: transparent;
			}

			#search:focus {
				outline: 0;
			}

			#search-icon {
				height: 42px;
				width: 42px;
			}

			#result-table {
				font-size: 18px;
				margin: 40px auto 0px auto;
				max-width: 960px;
			}

			#result-table caption {
				color: #f9f9f9;
				font-size: 24px;
				text-align: center;
			}

			#result-table thead {
				display: none;
			}

			footer {
				position: fixed;
				top: 0px;
				width: 100%;
			}
		</style>
	</head>
	<body>
		<h1>UNCOVER<br><small>貪污查詢網站</small></h1>
		<input id="search" name="search" type="text" placeholder="by Name" autofocus />
		<a href="javascript: index.fetchResult();"><img id="search-icon" src="images/search.svg" alt="search"></a>
		<table id="result-table" class="table">
			<caption></caption>
			<thead>
				<tr>
					<th>被告</th>
					<th>法院別</th>
					<th>判決字號</th>
					<th>判決日期</th>
					<th>判決案由</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
		<footer>
			<h4>建置中，目前僅包含民國100~102年地方法院裁判書</h4>
		</footer>
		<!-- Latest compiled and minified JavaScript -->
		<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
		<script>
			var s,
				index = {
				init: function() {
					s = this.settings;
					this.bindSearchOnOK();
				},
				settings: {
					searchInput: $('#search'),
					searchIcon: $('#search-icon'),
					resultTable: $('#result-table'),
					resultTableCaption: $('#result-table caption'),
					resultTableThead: $('#result-table thead'),
					resultTableTbody: $('#result-table tbody'),
					resultListGroup: $('#result-list-group'),
					ajaxLoader: '<img src="./images/ajaxloader.svg" alt="loading">'
				},
				fetchResult: function() {
					s.resultTableCaption.html(s.ajaxLoader);
					s.resultTableThead.hide();
					s.resultTableTbody.hide();

					var apiUrl = './api/v1/name/' + s.searchInput.val();
					$.ajax({
						url: apiUrl,
						dataType: 'json',
						success: function(json) {
							s.resultTableCaption.html('查詢結果');
							if(json.success && json.result.length) {
								var innerHtml = '';
								$.each(json.result, function(i, result) {
									innerHtml += '<tr>';
									innerHtml += '<td>' + result.name + '</td>';
									innerHtml += '<td>' + result.court + '</td>';
									innerHtml += '<td>' + result.year + '年' + result.case + '字第'+ result.no + '號</td>';
									innerHtml += '<td>' + result.date + '</td>';
									innerHtml += '<td>' + result.cause + '</td>';
									innerHtml += '</tr>';
								});
								s.resultTableTbody.html(innerHtml);
								s.resultTableThead.fadeIn('normal');
								s.resultTableTbody.fadeIn('normal');
							} else {
								s.resultTableCaption.html('查無不法，謝謝指教');
							}
						},
						error: function() {
							s.resultTableCaption.html('寬宏無法大量，資料庫停擺');						}
					});
				},
				bindSearchOnOK: function() {
					s.searchInput.keypress(function(event){
					    if (event.keyCode == 13)
					    	index.fetchResult();
					});
				}
			};

			$(function() {
			    index.init();
			});
		</script>
	</body>
</html>
