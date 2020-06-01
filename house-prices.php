<!DOCTYPE html>
<html lang="zxx" class="no-js">

<?php include('layouts/head.php'); ?>
<link rel="stylesheet"
      href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.0.3/styles/default.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.0.3/highlight.min.js"></script>
<script>hljs.initHighlightingOnLoad();</script>



<body>

	<?php include('layouts/header.php'); ?>

	<!-- start banner Area -->
	<section class="banner-area relative">
		<div class="container">
			<div class="row d-flex align-items-center justify-content-center">
				<div class="about-content col-lg-12">
					<h1 class="text-white">
						Portfolio Details
					</h1>
					<p class="link-nav">
						<span class="box">
							<a href="index.html">Home </a>
							<a href="portfolio.php">Portfolio</a>
					</span>
				</div>
			</div>
		</div>
	</section>
	<!-- End banner Area -->

	<!-- Portfolio Details Area -->
	<section class="portfolio_details_area section-gap">
		<div class="container">
			<div class="portfolio_details_inner">
				<div class="row">
					<div class="col-md-6">
						<div class="left_img img-frame">
							<span class="img-helper"></span>
							<img class="img-fluid vertical-align-middle" src="img/originaux/house-prices-logo.png" alt="">
						</div>
					</div>
					<div class="offset-md-1 col-md-5">
						<div class="portfolio_right_text mt-30">
							<h4>House prices</h4>
							<blockquote class="generic-blockquote">
								With 79 explanatory variables describing (almost) every aspect of residential homes in Ames, Iowa, this competition challenges you to predict the final price of each home.
							</blockquote>
							<ul class="list">
								<li><span>Rating</span>: <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
									 class="fa fa-star"></i></li>
								<li><span>Client</span>: Kaggle.com</li>
								<li><span>Website</span>: <a href="https://www.kaggle.com/c/house-prices-advanced-regression-techniques" target="_blank">Kaggle.com - House Prices</a></li>

								<li><span>Completed</span>: 2020</li>
							</ul>
							<ul class="list social_details">
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-behance"></i></a></li>
								<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
								<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
							</ul>
						</div>
					</div>
				</div>

				<div>
					<script type="text/javascript">
						// https://stackoverflow.com/questions/187619/is-there-a-javascript-solution-to-generating-a-table-of-contents-for-a-page
						var c = function() {
						    return({
						        log: function(msg) {
						          consoleDiv = document.getElementById('console');
						          para = document.createElement('p');
						          text = document.createTextNode(msg);
						          para.appendChild(text);
						          consoleDiv.appendChild(para);
						        }
						    });
						}();

						window.onload = function () {
						    var toc = "";
						    var level = 0;
						    var maxLevel = 3;

						    document.getElementById("contents").innerHTML =
						        document.getElementById("contents").innerHTML.replace(
						            /<h([\d])>([^<]+)<\/h([\d])>/gi,
						            function (str, openLevel, titleText, closeLevel) {
						                if (openLevel != closeLevel) {
										 c.log(openLevel)
						                    return str + ' - ' + openLevel;
						                }

						                if (openLevel > level) {
						                    toc += (new Array(openLevel - level + 1)).join("<ol class=\"ordered-list\">");
						                } else if (openLevel < level) {
						                    toc += (new Array(level - openLevel + 1)).join("</ol>");
						                }

						                level = parseInt(openLevel);

						                var anchor = titleText.replace(/ /g, "_");
						                toc += "<li><a href=\"#" + anchor + "\">" + titleText
						                    + "</a></li>";

						                return "<h" + openLevel + "><a name=\"" + anchor + "\">"
						                    + titleText + "</a></h" + closeLevel + ">";
						            }
						        );

						    if (level) {
						        toc += (new Array(level + 1)).join("</ol>");
						    }

						    document.getElementById("toc").innerHTML += toc;
						};
					</script>

				</div>
				<div id='console'></div>
			    <div id="toc">
			        <h3>Table of Contents</h3>
			    </div>
			    <hr/>
				<div id="contents">
					<h1>Data preparation</h1>
					<div class="section-top-border">
						<h2>Import libraries and datasets</h2>
						<p>Firstly, the datasets offered by Kaggle.com are imported as some usefull librarys for this first notebook :</p>
						<pre>
							<code>
	import pandas as pd
	from sklearn.model_selection import train_test_split
	import LibrairiePerso_v4_4 as ownLibrart
	import seaborn as sns 
	import numpy as np
	import copy

	dataset = pd.read_csv("C:/Users/Julie/Documents/Big_Data/train_from_Kaggle.csv", sep=",")
	submission = pd.read_csv("C:/Users/Julie/Documents/Big_Data/test_from_Kaggle.csv", sep=",")
							</code>
						</pre>
					</div>
					<h2>Split train/test</h2>
					<div class="section-top-border">
						<pre>
							<code>
	exp = list(dataset.columns.values)
	exp.remove('SalePrice')
	X = dataset[exp]
	y = dataset['SalePrice']

	X_train, X_test, y_train, y_test = \
	            train_test_split(X, y, test_size=0.3 , 
	                            random_state= 100 )
		                    </code>
		                </pre>
	                </div>
	                <h2>Replacement of missings data</h2>
	                <div class="section-top-border">
						<p>The features missings data can be real missings data or have a real signification like &quot;no basement bathroom&quot;. When the data are really missing they are replaced by the mode. In the other case they are replaced by 0 for continuous features or &quot;eNa&quot; for categorical features.</br>
						A hand writted function allows to replace missing values of a feature, by the mode of the train set, for a particular house group from the same neighborhood.</p>
						<h3>Replacement for continuous features where values are missing</h3>
						<pre>
							<code>
	X_train_MasVnrArea = X_train.groupby("Neighborhood")["MasVnrArea"].median().to_frame()
	ownLibrary.replaceByGroupMedian([X_train, X_test, submission], X_train_MasVnrArea, "MasVnrArea", "Neighborhood")

	X_train_LotFrontage = X_train.groupby("Neighborhood")["LotFrontage"].median().to_frame()
	ownLibrary.replaceByGroupMedian([X_train, X_test, submission], X_train_LotFrontage, "LotFrontage", "Neighborhood")

	for df in [X_train, X_test, submission]:   
	        
	    for col in ('GarageYrBlt','GarageArea', 'GarageCars'):
	        df[col] = df[col].fillna(0)       
	    for col in ('BsmtFinSF1', 'BsmtFinSF2', 'BsmtUnfSF','TotalBsmtSF'):
	        df[col] = df[col].fillna(0)
	    for col in ('BsmtFullBath', 'BsmtHalfBath'):
	        df[col] = df[col].fillna(0)
							</code>
						</pre>
						<h3>Some missing values replacement for features considered as categorical</h3>
						<pre>
							<code>
	for df in [X_train, X_test, submission]:
	    df.Alley.fillna("eNA", inplace = True)
	    df.BsmtCond.fillna("eNA", inplace = True)
	    df.BsmtQual.fillna("eNA", inplace = True)

	for df in [X_train, X_test, submission]:
	    df['MasVnrType'] = df['MasVnrType'].fillna(df['MasVnrType'].mode()[0])
	    df['Functional'] = df['Functional'].fillna(df['Functional'].mode()[0])
	    df['MSZoning'] = df['MSZoning'].fillna(df['MSZoning'].mode()[0])
							</code>
						</pre>
					</div>
					<div class="section-top-border">
						<h2>Features deletion</h2>
						<p>Some features appear to be unusuable, they are deleted. I will understand later that it was a mistake and that they could be used differently than directly, for example by being combined with other features.</p>
						<h3>Examples of features deletion</h3>
						<pre>
							<code>
	for df in [X_train, X_test, submission]:
	    df.drop(['Utilities'], axis=1, inplace=True)
	    df.drop(['Street'], axis=1, inplace=True)
	    df.drop(['Condition2'], axis=1, inplace=True)
	    df.drop(['RoofMatl'], axis=1, inplace=True)
							</code>
						</pre>
					</div>
					<div class="section-top-border">
						<h2>Outliers detection and correction</h2>
						<p>To detect outliers, boxplot have been used. The outliers have then been corrected by capping the values of continuous data. here is the example for the TotalBsmtSF feature.</p>
						<pre>
							<code>
	plt.figure(figsize=(16,8))
	sns.boxplot(x=var,data=train_complet)
	plt.show()
	boxplot_stats(train_complet[var])
							</code>
						</pre>
						<div class="img-frame">
							<img class="image img-fluid img-inpost" src="img/house-prices/TotalBsmtSF-outliers.png" alt="">
						</div>
						
						<p>The function gives us informations about the features's outliers.</p>
						<pre>
							<code>
	[{'cihi': 1018.5865615891045,
	'cilo': 967.4134384108955,
	'fliers': array([   0,    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
			0,    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
			0,    0,    0,    0,    0,    0,    0, 3094, 2110, 2136, 2633,
			2396, 6110, 2121, 2392, 3200, 2109, 3138, 3206, 2223, 2444, 2136,
			2153, 2158], dtype=int64),
	'iqr': 521.0,
	'mean': 1061.8043052837572,
	'med': 993.0,
	'q1': 793.0,
	'q3': 1314.0,
	'whishi': 2077,
	'whislo': 105}]
							</code>
						</pre>
						<p>These informations are used to cap the feature's values</p>
						<pre>
							<code>
	train_complet['TotalBsmtSF'] = train_complet['TotalBsmtSF'].clip(105,2077)
							</code>
						</pre>
						<p>After having been capped, the feature observes a rise of his correlation with the target feature. Indeed, for a simple linear regression, the R² passes from 37,5% to 42%.</p>
						<div class="row mb-0">
							<div class="col-lg-6 col-md-6 col-sm-12 img-frame">
								<img class="image img-fluid" src="img/house-prices/TotalBsmtSF-rsquared-before.png" alt="">
							</div>
							<div class="col-lg-6 col-md-6 col-sm-12 img-frame">
								<img class="image img-fluid" src="img/house-prices/TotalBsmtSF-rsquared-after.png" alt="">
							</div>
						</div>
					</div>
					<div class="section-top-border">
						<h2>Target feature isn&#39;t correctly distributed</h2>
						<p>The target feature &quot;SalePrice&quot; has to be correctly distributed, the np.log1p() function offers the best correction. But it's the np.log() function that has been used to achieve that correction as it was easyest to reverse the prediction later. We can see here the effects of the np.log1p() function on the SalePrice feature distribution, before and after the transformation :</p>
						<pre>
							<code>
	train["SalePrice"] = np.log1p(train["SalePrice"])
							</code>
						</pre>
						<div class="row mb-0">
							<div class="col-lg-6 col-md-6 col-sm-12 img-frame">
								<img class="image img-fluid" src="img/house-prices/SalePrice-distribution-before.PNG" alt="">
							</div>
							<div class="col-lg-6 col-md-6 col-sm-12 img-frame">
								<img class="image img-fluid" src="img/house-prices/SalePrice-distribution-after.PNG" alt="">
							</div>
						</div>
					</div>
					<div class="section-top-border">
						<h2>Scale Features</h2>
						<p>The continuous features can then be scaled. The methods used will be presented further.</p>
						<pre>
							<code>
	quantitative = ['LotFrontage','LotArea','YearBuilt','YearRemodAdd','MasVnrArea','BsmtFinSF1','BsmtFinSF2','BsmtUnfSF','TotalBsmtSF','1stFlrSF','2ndFlrSF','GrLivArea','GarageYrBlt','GarageArea','WoodDeckSF','OpenPorchSF','EnclosedPorch','ScreenPorch', 'GarageArea', 'GrLivArea', '1stFlrSF', 'TotalBsmtSF']
	for df in ['X_train','X_test','submission']:
		df = ownLibrary.scale_features_in_df(df, quantitative, scaleMethod)
							</code>
						</pre>

					</div>
					<div class="section-top-border">
						<h2>Export of the modified dataset for following notebooks</h2>
						<p>The modified dataset are exported to csv. The following notebooks will now work on it without having to prepare again the data to this waypoint.</p>
						<pre>
							<code>
	X_train['SalePrice'] = y_train
	X_train.to_csv ("path/Initial_train_rwrk.csv", index = False, header=True)
	X_test['SalePrice'] = y_test
	X_test.to_csv ("path/Initial_test_rwrk.csv", index = False, header=True)

	submission['SalePrice'] = 0
	submission.to_csv ("path/Initial_submission_rwrk.csv", index = False, header=True)
							</code>
						</pre>
					</div>
					<div class="section-top-border">
						<h1>Best data transformation finder</h1>
						<p>A hand writted function allows to test differents combination of Scaling features method and features transformation methods</p>
						<p>Here we find the differents <b>scaling methods</b> that can be applied to the early prepared dataset :
							<ul class="unordered-list">
							    <li>No scaling</li>
							    <li>New value = (value - feature&#39;s min value) / (feature&#39;s max value - feature&#39;s min value)</li>
							    <li>New value = value / feature&#39;s max value</li>
							    <li>New value = (value - feature&#39;s mean value) / feature&#39;s standard deviation</li>
							    <li>New value = preprocessing.StandardScaler() function</li>
							</ul>
						</p>
						<p>The differents results can then have their correlation with the target feature tested. A data frame give us the differents scores and allows to chose the best method for each feature.</br>
						Another hand writted function allows to compare differents features transformations :
						<ul class="unordered-list">
						    <li>No modification of the feature</li>
						    <li>A data tree regressor finds bins wich are the most correlated to the target feature</li>
						    <li>Polynomial transformations of differents orders</li>
						</ul>
						</p>
						<h2>Methods comparison data frame</h2>
						<p>The two previously described functions product a data frame containing the differents R&sup2; scores. The following data frames are a shortened version of the complete one with less features and less scale methods concerned. </br>
						The LotArea feature is an insterresting one, the "natural" correlation (if no transformation at all) with the target feature SalePrice presents a R² of 8.54%. The data tree regressor manages to create bins that have a correlation of 20.20% wich is a great improvement. The polynomial regression also improve the R² but not as much as the data tree regressor method.</br>
						The second table indicates that these results can be improved again by scaled the feature before the transformations. 
						</p>
						<span><b>Differents transformation with not scaled data</b></span>
						<div class="progress-table-wrap mb-30">
							<div class="progress-table">
							    <div class="table-head">
							      <div class="serial">Not Scaled</div>
							      <div class="serial">R²</div>
							      <div class="serial">DTR R²</div>
							      <div class="serial">PR2 R²</div>
							      <div class="serial">PR3 R²</div>
							    </div>
							    <div class="table-row">
							      <div class="serial">LotFrontage</div>
							      <div class="serial">12.21</div>
							      <div class="serial">14.72</div>
							      <div class="serial">12.72</div>
							      <div class="serial">12.95</div>
							    </div>
							    <div class="table-row">
							      <div class="serial">LotArea</div>
							      <div class="serial">8.54</div>
							      <div class="serial">20.20</div>
							      <div class="serial">16.09</div>
							      <div class="serial">18.45</div>
							    </div>
							    <div class="table-row">
							      <div class="serial">YearBuilt</div>
							      <div class="serial">24.97</div>
							      <div class="serial">36.31</div>
							      <div class="serial">34.58</div>
							      <div class="serial">34.39</div>
							    </div>
							</div>
						</div>
						<span><b>Differents transformation with scaled data</b></span>
						<div class="progress-table-wrap">
							<div class="progress-table">
							    <div class="table-head">
							      <div class="serial">Scaled</div>
							      <div class="serial">R²</div>
							      <div class="serial">DTR R²</div>
							      <div class="serial">PR2 R²</div>
							      <div class="serial">PR3 R²</div>
							    </div>
							    <div class="table-row">
							      <div class="serial">LotFrontage</div>
							      <div class="serial">12.21</div>
							      <div class="serial">14.68</div>
							      <div class="serial">12.68</div>
							      <div class="serial">12.83</div>
							    </div>
							    <div class="table-row">
							      <div class="serial">LotArea</div>
							      <div class="serial">8.54</div>
							      <div class="serial">20.71</div>
							      <div class="serial">16.87</div>
							      <div class="serial">18.89</div>
							    </div>
							    <div class="table-row">
							      <div class="serial">YearBuilt</div>
							      <div class="serial">24.97</div>
							      <div class="serial">35.79</div>
							      <div class="serial">34.64</div>
							      <div class="serial">34.44</div>
							    </div>
							</div>
						</div>
					</div>
					<div class="section-top-border">
						<h2> Data tree regressor bins</h2>
						<p>A parameter of the data tree regressor bins identifier function allows to print the bins as a python object. This object will furtherly be used to replace the values of the differents concerned features with another hand writted function.</p>
						<pre>
							<code>
	'LotFrontage': {
		1: [0,60.0],
		2: [61.0,74.0],
		3: [75.0,90.0],
		4: [91.0,220.0]
	},
	'LotArea': {
		1: [0,8635],
		2: [8640,10970],
		3: [10991,13680],
		4: [13682,430490]
	},
							</code>
						</pre>

					</div>
					<div class="section-top-border">
					<h2>Categorical features regrouping method</h2>
						<p>The method used to regroup categorical feature is based on a boxplot study. The boxplot are showing the correlation with the target feature for each states of a particular categorical feature. The similar state of this feature are then regrouped together.</br>
						Here is an example with the BsmtCond feature. On the following picture, the correlation between each state of the feature and the target feature is represented with a boxplot. The blue boxplot and the brown wont be regrouped, they aren't similar with any of the other boxplot. The three last states (eNa for no basement, Fa and Po) have more similar boxplot so they will be regrouped together.
						</p>
						<div class="img-frame">
							<img class="image img-fluid img-inpost" src="img/house-prices/BsmtCond-regroup.PNG" alt="">
						</div>
						<p>At the end of the study for each feature, another object python gives the list of furtherly regrouped states.</p>
						<pre>
							<code>
    'BsmtQual': {
        1: ["Ex"],
        2: ["Gd","TA"],
        3: ["Fa","eNA"]
    },
    'BsmtCond': {
        1: ["TA"],
        2: ["Gd"],
        3: ["Fa","Po","eNA"]
    },
							</code>
						</pre>
					</div>
					<div class="section-top-border">
						<h1>Place to the action</h1>
						<p>Now that features have been studyed and transformations chosen the action can start.</p>
					</div>
					<div class="section-top-border">
						<h2>Transformation based on the previous study</h2>
						<p>If the data preparation notebook hasn&#39;t do it, the continuous features are firstly scaled according to the method previously identified. Differents list of features are set for the rest of the process. Here, some continuous features are placed in lists for features wich will be scaled (scaleMethod1 and 3) while some won't be scaled (scaleMethod0). We retrieve also the features which need a binning with the data tree regressor and those which need a polynomial transformation of order 2 or 3. The "ignore" list will be use by the dichotomization function.</p>
						<span><b>Define the list of features for each transformation type</b></span>
						<pre>
							<code>
	scaleMethod0 = ['LotFrontage','YearBuilt','YearRemodAdd','GarageYrBlt','WoodDeckSF']
	scaleMethod1 = ['ScreenPorch','BsmtFinSF2','1stFlrSF','2ndFlrSF','TotalBsmtSF','GrLivArea']
	scaleMethod3 = ['EnclosedPorch','MasVnrArea','LotArea','BsmtUnfSF','OpenPorchSF','GarageArea','BsmtFinSF1']

	var_dtr = ['LotFrontage','YearBuilt','YearRemodAdd','GarageYrBlt','WoodDeckSF','BsmtFinSF2','LotArea','BsmtUnfSF','OpenPorchSF']
	var_base = ['Id', 'MiscVal', 'SalePrice', 'SalePrice_log']
	var_lr = ['ScreenPorch']
	var_base_pr2 = ['1stFlrSF','2ndFlrSF','GarageArea']
	var_base_pr3 = ['EnclosedPorch','MasVnrArea','TotalBsmtSF','GrLivArea','BsmtFinSF1']

	ignore = var_base + var_base_pr2 + var_base_pr3 + var_lr
							</code>
						</pre>
						<span><b>Performs the scale tranformation</b></span>
						<pre>
							<code>
	X_train = ownLibrary.scale_features(X_train, scaleMethod1, 1)
	X_test = ownLibrary.scale_features(X_test, scaleMethod1, 1)
	submission = ownLibrary.scale_features(submission, scaleMethod1, 1)

	X_train = ownLibrary.scale_features(X_train, scaleMethod3, 3)
	X_test = ownLibrary.scale_features(X_test, scaleMethod3, 3)
	submission = ownLibrary.scale_features(submission, scaleMethod3, 3)
							</code>
						</pre>
						<p>The states of categorical features are regrouped and the continuous features concerned are binned according to the data tree regressor bins. The regroupments are performed by a hand writted function. The function loop over a dataset's features, if a feature is in one of the python object that define the regroupment, so the regroupment is done.</p>
						<span><b>Performs the regroupments and binning</b></span>
						<pre>
							<code>
    for column in dataset:      
	    # ------------------------ If the feature is categorical ----------------------   
	    if (column in ListeDesReglesQuali):
	        columnDiscretise = ownLibrary.discretise_1col_quali(dataset[column], column, ListeDesReglesQuali[column])
	        dataset.drop([column], axis=1, inplace=True)
	        dataset[column] = columnDiscretise

	    # ------------------------ If the feature is continuous ----------------------                            
	    elif (column in ListeDesReglesQuantiKB):
	        columnDiscretise = ownLibrary.discretise_1col_quanti(dataset[column], column, ListeDesReglesQuantiKB[column])
	        if( len(dataset[column]) != len(columnDiscretise)):
	            print('len(dataset[column]) != len(columnDiscretise) : ' + str(dataset[column]) + ' != ' + str(columnDiscretise))
	        else:    
	            dataset.drop([column], axis=1, inplace=True)
	            dataset[column] = columnDiscretise     
							</code>
						</pre>
					</div>
					<div class="section-top-border">
						<h2>Creation of new features</h2>
						<p>A bunch of new features can be created from the existings one. For example, the quality of fireplaces and their quality are combined to form one unique feature.</p>
						<span><b>Creation of new features</b></span>
						<pre>
							<code>
	for df in [rgrpd_train, rgrpd_test, rgrpd_submission]:
		df["NewFirePlaces"] = df["Fireplaces"].astype(str) + df["FireplaceQu"].astype(str)
		df["NewExterQualCond"] = df["ExterQual"].astype(str) + df["ExterCond"].astype(str)
		df["NewCentrAirElec"] = df["CentralAir"].astype(str) + df["Electrical"].astype(str)
		df["NewKitchen"] = df["KitchenAbvGr"].astype(str) + df["KitchenQual"].astype(str)
		df["NewSale"] = df["SaleType"].astype(str) + df["SaleCondition"].astype(str)
							</code>
						</pre>
					</div>
					<div class="section-top-border">
						<h2>Dichotomization</h2>
						<p>A short hand writted function allows to dichotomize a given dataset ignoring specified features. The ignored features are the continuous ones who haven&#39;t been binned, thoses which will undergo a polynomial transformation and a few else like the target feature.</p>
						<span><b>Performs the dichotomization</b></span>
						<pre>
							<code>
	train_dicho = ownLibrary.dichotomize_dataset(rgrpd_train, ignore)
	test_dicho = ownLibrary.dichotomize_dataset(rgrpd_test, ignore)
	submission_dicho = ownLibrary.dichotomize_dataset(rgrpd_submission, ignore)
							</code>
						</pre>
					</div>
					<div class="section-top-border">
						<h2>Polynomial transformation</h2>
						<p>A hand writted function performs a polynomial transformation on a features list of a given dataset and a given polynomial order. The function returns the transformed dataset. Here are performed a first polynomial transformation of order 2 on the concerned features, the resulting dataset is then used for a second transformation of order 3 for another list of features defined at the begining of the notebook.</p>
						<span><b>Performs the polynomial transformation</b></span>
						<pre>
							<code>
	train_pr2_transformed = ownLibrary.PolynomialRegrTransformationReturnDF(train_poly, var_base_pr2, 2)
	test_pr2_transformed = ownLibrary.PolynomialRegrTransformationReturnDF(test_poly, var_base_pr2, 2)
	submission_pr2_transformed = ownLibrary.PolynomialRegrTransformationReturnDF(submission_poly, var_base_pr2, 2)

	train_pr3_transformed = ownLibrary.PolynomialRegrTransformationReturnDF(train_pr2_transformed, var_base_pr3, 3)
	test_pr3_transformed = ownLibrary.PolynomialRegrTransformationReturnDF(test_pr2_transformed, var_base_pr3, 3)
	submission_pr3_transformed = ownLibrary.PolynomialRegrTransformationReturnDF(submission_pr2_transformed, var_base_pr3, 3)
							</code>
						</pre>
					</div>
					<div class="section-top-border">
						<h2>Harmonization of features presence in each dataset</h2>
						<p>Arrived to this steps, some dataset can have more features than another one. For example, the lot area feature has been transformed into several bins, the train dataset has no bin number 1 of this feature. The harmonization insert this feature/bin in the train dataset and fill it with 0 values (as the feature is a dichotomized one), indicating that no observation are concerned by this feature.</br>
						Here is an example with the test dataset :
						</p>
						<span><b>Identify the features which are present in the train and submission dataset but not in the test one</b></span>
						<pre>
							<code>
	a = train_rwrk.columns.difference(test_rwrk.columns)
	b = submission_rwrk.columns.difference(test_rwrk.columns)
	manqueTest = a.tolist() + b.tolist()
	print ('Result : ' + manqueTest)

	Result : ['Exterior1st_3', 'NewKitchen_23', 'Exterior1st_3', 'NewExterQualCond_12', 'NewKitchen_23']
							</code>
						</pre>
						<span><b>Harmonization for the test dataset and result</b></span>
						<pre>
							<code>
	for colonne in manqueTest :
    	test_rwrk[colonne] = 0

	a = train_rwrk.columns.difference(test_rwrk.columns)
	b = submission_rwrk.columns.difference(test_rwrk.columns)
	manqueTest = a.tolist() + b.tolist()
	print ('Result : ' + manqueTest)

	Result : []
							</code>
						</pre>
					</div>
					<div class="section-top-border">
						<h2>Features selection</h2>
						<p>A stepwise function decide alone of the features that will be use for the modelisation part, I admit to have found this function on the web. The stepwise function used can be found on this <a href="https://datascience.stackexchange.com/questions/24405/how-to-do-stepwise-regression-using-sklearn/24447#24447">Stepwise function source</a></p>
						<span><b>Perform a stepwise features selection</b></span>
						<pre>
							<code>
	variables = list(train_rwrk.columns)
	ignore = ['SalePrice','Id','SalePrice_log']

	colonnes = [var for var in variables if var not in ignore ]

	X = pd.DataFrame(train_rwrk, columns=colonnes)
	y = train_rwrk['SalePrice_log']
	result_stepwise = ownLibrary.stepwise_selection(X, y)
							</code>
						</pre>
						<p>The stepwise selection results in approximately 40 features, depending on the combination of scaling and transformation methods used.</p>
					</div>
					<div class="section-top-border">
						<h2>Launching modelisation</h2>
						<p>The library GridSearchCV allows to find the best parameters for a bunch of models. When those parameters are found, the features selected by the stepwise are transmited to a hand writted function than run severals models fitted with the training data. The predicted values for each of these models are stored in two data frame, one for the training dataset predicted values, and one for the test dataset.</p>
						<p>A last hand writted function print the results of these modelisation for the training and test datasets, allowing to have information about overfitting or underfitting presence.</p>
						<span><b>Define the features and models to use</b></span>
						<pre>
							<code>
	var_stepwise = result_stepwise
	y = 'SalePrice_log'
	models = {
	    'fa' : {
	        'label' : 'Forêt aléatoire',
	        #'function' : RandomForestRegressor(n_estimators=7, max_depth=11, min_samples_split=3, min_samples_leaf=1, random_state=0, n_jobs=-1)
	        'function' : RandomForestRegressor(n_estimators=35, max_depth=11, min_samples_split=3, min_samples_leaf=1, random_state=0, n_jobs=-1)
	    },
	    ...
	    'mrl' : {
	        'label' : 'Regression linéaire multivariée',
	        'function' : LinearRegression()
	    }

	}
							</code>
						</pre>
						<span><b>Perform the modelisation</b></span>
						<pre>
							<code>
	for model in models :
	    models[model]['function'].fit(train_rwrk[var_stepwise], train_rwrk[y])
	predictions_train = ownLibrary.runModels1DS(train_rwrk, 'train', var_stepwise, y, models)
	predictions_test = ownLibrary.runModels1DS(test_rwrk, 'test', var_stepwise, y, models)
							</code>
						</pre>
						<span><b>Printing the results</b></span>
						<pre>
							<code class="python">
	ownLibrary.afficheResults(predictions_train, predictions_test, 'SalePrice', models)

	------------- Random forest -------------

	Train : R² = 97.4% , rsquared = 97.8% , corr = 98.9% , MSE = 160125383.76
	Test : R² = 84.0% , rsqaured = 84.4% , corr = 91.8% , MSE = 1029079283.89

	------------- Decision tree - Regressor -------------

	Train : R² = 98.4% , rsquared = 98.4% , corr = 99.2% , MSE = 100759539.13
	Test : R² = 74.0% , rsqaured = 74.5% , corr = 86.3% , MSE = 1671249530.34

	------------- KNN -------------

	Train : R² = 64.4% , rsquared = 66.3% , corr = 81.4% , MSE = 2224200972.83
	Test : R² = 58.4% , rsqaured = 61.0% , corr = 78.1% , MSE = 2676487093.09

	------------- Multivariation linear regression -------------

	Train : R² = 92.9% , rsquared = 93.0% , corr = 96.4% , MSE = 443628942.43
	Test : R² = 89.9% , rsqaured = 89.9% , corr = 94.8% , MSE = 650386382.74
							</code>
						</pre>
						<p>The 89,9% R² with the Multivariate linear regression is currently the best score that I got. To get it used the following transformations method of my continuous features :</p>
						<div class="row grid">
							<div class="single-work col-lg-4 col-md-6 col-sm-12 wow fadeInUp" data-wow-duration="2s">
								<ul class="unordered-list">
								    <li>Binning with the DTR 
								    	<ul>
								    		<li>LotFrontage</li>
								    		<li>LotArea</li>
								    		<li>YearBuilt</li>
								    		<li>YearRemodAdd</li>
								    		<li>BsmtFinSF2</li>
								    		<li>GarageYrBlt</li>
								    		<li>WoodDeckSF</li>
								    		<li>OpenPorchSF</li>
								    		<li>EnclosedPorch</li>
							    		</ul>
								    </li>
								</ul>
							</div>
							<div class="single-work col-lg-4 col-md-6 col-sm-12 wow fadeInUp" data-wow-duration="2s">
								<ul class="unordered-list">
								    <li>No transformation
										<ul>
								    		<li>MasVnrArea</li>
								    		<li>ScreenPorch</li>
							    		</ul>
								    </li>

								</ul>
							</div>
							<div class="single-work col-lg-4 col-md-6 col-sm-12 wow fadeInUp" data-wow-duration="2s">
								<ul class="unordered-list">
								    <li>Polynomial transformation order 2
										<ul>
								    		<li>1stFlrSF</li>
								    		<li>GarageArea</li>
							    		</ul>
								    </li>
								    <li>Polynomial transformation order 3
								    	<ul>
								    		<li>BsmtFinSF1</li>
								    		<li>BsmtUnfSF</li>
								    		<li>TotalBsmtSF</li>
								    		<li>2ndFlrSF</li>
								    		<li>GrLivArea</li>
								    	</ul>
								    </li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End Portfolio Details Area -->

	<!-- Start Contact Area -->
	<section class="contact-area section-gap">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="contact-title">
						<h2>Contact Me</h2>
						<p>If you are looking at blank cassettes on the web, you may be very confused at the difference in price. You may see
							some for as low as $.17 each.</p>
					</div>
				</div>
			</div>

			<div class="row mt-80">
				<div class="col-lg-4 col-md-4">
					<div class="contact-box">
						<h4>+44 2365 654 8962</h4>
					</div>
				</div>
				<div class="col-lg-4 col-md-4">
					<div class="contact-box">
						<h4>information@colorlib.com</h4>
					</div>
				</div>
				<div class="col-lg-4 col-md-4">
					<div class="contact-box">
						<h4>kenedyjackson.me</h4>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12 text-center">
					<a href="#" class="primary-btn mt-50" data-text="Hire Me">
						<span>H</span>
						<span>i</span>
						<span>r</span>
						<span>e</span>
						<span> </span>
						<span>M</span>
						<span>e</span>
					</a>
				</div>
			</div>
		</div>
	</section>
	<!-- End Contact Area -->

	<!-- start footer Area -->
	<footer class="footer-area">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-12">
					<div class="footer-top flex-column">
						<div class="footer-logo">
							<a href="#">
								<img src="img/logo.png" alt="">
							</a>
							<h4>Follow Me</h4>
						</div>
						<div class="footer-social">
							<a href="#"><i class="fa fa-facebook"></i></a>
							<a href="#"><i class="fa fa-twitter"></i></a>
							<a href="#"><i class="fa fa-dribbble"></i></a>
							<a href="#"><i class="fa fa-behance"></i></a>
						</div>
					</div>
				</div>
			</div>
			<div class="row footer-bottom justify-content-center">
				<p class="col-lg-8 col-sm-12 footer-text">
					<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
			</div>
		</div>
	</footer>
	<!-- End footer Area -->

	<!-- ####################### Start Scroll to Top Area ####################### -->
	<div id="back-top">
		<a title="Go to Top" href="#">
			<i class="lnr lnr-arrow-up"></i>
		</a>
	</div>
	<!-- ####################### End Scroll to Top Area ####################### -->

	<script src="js/vendor/jquery-2.2.4.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
	 crossorigin="anonymous"></script>
	<script src="js/vendor/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhOdIF3Y9382fqJYt5I_sswSrEw5eihAA"></script>
	<script src="js/easing.min.js"></script>
	<script src="js/hoverIntent.js"></script>
	<script src="js/superfish.min.js"></script>
	<script src="js/mn-accordion.js"></script>
	<script src="js/jquery.ajaxchimp.min.js"></script>
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<script src="js/jquery.nice-select.min.js"></script>
	<script src="js/isotope.pkgd.min.js"></script>
	<script src="js/jquery.circlechart.js"></script>
	<script src="js/mail-script.js"></script>
	<script src="js/wow.min.js"></script>
	<script src="js/main.js"></script>
</body>

</html>