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

			input:focus {
				outline: 0;
			}

			.search input {
				font-size: 32px;
				border: none;
				border-bottom: 2px solid #ccc;
				background-color: transparent;
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
				position: absolute;
				top: 0px;
				width: 100%;
			}
		</style>
	</head>
	<body>
		<h1>UNCOVER<br><small>貪污查詢網站</small></h1>
		<div class="search">
			<input id="name" name="name" type="text" placeholder="名稱" autofocus />
			<a href="javascript: index.fetchResult();"><img id="search-icon" src="images/search.svg" alt="search"></a>
			<!-- <input id="court" name="court" type="text" placeholder="判決法庭" />
			<input id="year" name="year" type="text" placeholder="年" />
			<input id="case" name="case" type="text" placeholder="字" />
			<input id="no" name="no" type="text" placeholder="號" />
			<input id="from" name="from" type="text" placeholder="判決日期從" />
			<input id="to" name="to" type="text" placeholder="至" />
			<input id="cause" name="cause" type="text" placeholder="判決案由" /> -->
		</div>

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
			<h4>目前僅包含民國100~102年地方法院裁判書</h4>
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
					searchInput: $('.search input'),
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

					var apiUrl = './api/v1/judgements?' + s.searchInput.serialize();
					$.ajax({
						url: apiUrl,
						dataType: 'json',
						success: function(json) {
							s.resultTableCaption.html('查詢結果');
							if(!json.error && json.judgements.length) {
								console.log(json.error);
								var innerHtml = '';
								$.each(json.judgements, function(i, judgements) {
									innerHtml += '<tr>';
									innerHtml += '<td>' + judgements.name + '</td>';
									innerHtml += '<td>' + judgements.court + '</td>';
									innerHtml += '<td>' + judgements.year + '年' + judgements.case + '字第'+ judgements.no + '號</td>';
									innerHtml += '<td>' + judgements.date + '</td>';
									innerHtml += '<td>' + judgements.cause + '</td>';
									innerHtml += '</tr>';
								});
								s.resultTableTbody.html(innerHtml);
								s.resultTableThead.fadeIn('normal');
								s.resultTableTbody.fadeIn('normal');
							} else {
								s.resultTableCaption.html('查無結果');
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
