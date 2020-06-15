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
						Kaggle - House Prices
					</h1>
					<p class="link-nav">
						<span class="box">
							<a href="index.php">Home </a>
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
							<h4>House Prices</h4>
							<blockquote class="generic-blockquote">
								With 79 explanatory variables describing (almost) every aspect of residential homes in Ames, Iowa, this competition challenges you to predict the final price of each home.
							</blockquote>
							<ul class="list">
								<li><span>Website</span>: <a href="https://www.kaggle.com/c/house-prices-advanced-regression-techniques" target="_blank">Kaggle.com - House Prices</a></li>
                                <li><span>GitHub</span>: <a href="https://github.com/Jdecot/House-prices" target="_blank">GitHub repository</a></li>
                                <li><span>Last update</span>: June 2020 </li>
								<li><span>Rank</span>: 1741 / 5364 </li>
                                <li><span>R²</span>: 91,5 %</li>
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
						                    toc += (new Array(openLevel - level + 1)).join("<ol class=\"list-margin-left\">");
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
					<div class="section-top-border">
						<h1>Introduction</h1>
						<p>The study realised and presented here brings a possible solution to a Data Science competition organised by the website Kaggle.com. The competition, called House Prices, aims to estimate the sale prices of houses located in Ames, a town located in the state of Iowa in the U.S.A. The accuracy of the predictions permitted to obtain a rank in the competition.</p>

						<p>To achieve the study, Kaggle.com provides a dataset containing characteristics about the houses sold in the town. The dataset is split in two group of 1,460 houses. The difference between these two groups is that the first group includes the prices of the houses studied while the second is dedicated to test a potential modeling and doesn't include prices. Based on this dataset, this study will start by presenting a solution to prepare the data. The data are then used to elaborate a modeling of the unknown prices before being submitted to Kaggle.com to obtain a score.</p>  

						<p>The full study was divided in several notebooks. One performs the first processing of the data, such as replacing missing values or creating new features based on the existing ones. This processing is supported by a second notebook which performs an exploratory data analysis to identify for example, the outliers. After the first processing, the data are then analysed again with the help of a third notebook. The goal of this third notebook consists in finding the best transformation for the data. Indeed, different methods, such as scaling, polynomial transformation or discretization, are combined and tested. A fourth notebook then uses the data to perform the modeling with different models and compares their results to pick the best one. All these notebooks use a library that I built myself by picking functions found on the web or that have been hand-written.</p>
					</div>
					<h1>Data preparation</h1>
					<div class="section-top-border">
						<h2>Import libraries and datasets</h2>
						<p>Firstly, the datasets offered by Kaggle.com are imported as some useful libraries for this first notebook :</p>
						<pre>
							<code>
	import pandas as pd
	from sklearn.model_selection import train_test_split
	import LibrairiePerso_v4_4 as ownLibrary
	import seaborn as sns 
	import numpy as np
	import copy

	path ='C:/path-to-the-notebooks/'

	dataset = pd.read_csv(path + "train.csv", sep=",")
	submission = pd.read_csv(path + "test.csv", sep=",")
							</code>
						</pre>
					</div>
					<div class="section-top-border">
						<h2>Split train/test</h2>
						<p>The train dataset provided by Kaggle.com is then divided between a train and a test.</p>
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
	                <div class="section-top-border">
	                	<h2>Replacement of missing data</h2>
						<p>The features' missing data can be real missing data or have a real meaning like &quot;no basement bathroom&quot;. When the data are really missing they are replaced by the mode. In the other case they are replaced by 0 for continuous features or &quot;eNa&quot; for categorical features.</br>
						A hand-written function allows the replacing of missing values of a feature, by the mode of the train set, for a particular house group from the same neighborhood.</p>
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
						<h2>Features creations</h2>
						<p>Some features are created based on the solution provided by <a href="https://www.kaggle.com/mgmarques/houses-prices-complete-solution">https://www.kaggle.com/mgmarques/houses-prices-complete-solution</a>. Another group of features will be created after the states are regrouped.</p>
						<pre>
							<code>
	for df in [X_train, X_test, submission]:
	    df.loc[:, 'YrBltAndRemod']=df['YearBuilt']+df['YearRemodAdd']
	    df.loc[:, 'TotalSF']=df['TotalBsmtSF'] + df['1stFlrSF'] + df['2ndFlrSF']

	    ...

	    df.loc[:, 'haspool'] = df['PoolArea'].apply(lambda x: 1 if x > 0 else 0)
	    df.loc[:, 'has2ndfloor'] = df['2ndFlrSF'].apply(lambda x: 1 if x > 0 else 0)
							</code>
						</pre>
					</div>
					<div class="section-top-border">
						<h2>Features deletion</h2>
						<p>Some feature appear to be unusuable mostly because of too many missing values. They are therefor deleted. Before their deletion, some of them are combined with others to create new features.</p>
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
                        <h2>Outlier detection and correction</h2>
                        <div class="row align-items-center justify-content-between margin-bottom-0">
                            <div class="col-lg-6 about-left">
                                
                                <p>To detect outliers, boxplot is used. The outliers are then corrected by capping the values of continuous data. Here is the example for the TotalBsmtSF feature.</p>
                                <pre>
                                    <code>
    plt.figure(figsize=(16,8))
    sns.boxplot(x=var,data=train_complet)
    plt.show()
    boxplot_stats(train_complet[var])
                                    </code>
                                </pre>
                            </div>
                            <div class="col-lg-5 col-md-12 about-right">
                                <div class="img-frame">
                                    <img class="image img-fluid img-inpost" src="img/house-prices/TotalBsmtSF-outliers.PNG" alt="">
                                </div>
                            </div>
                        </div>

						<p>The boxplot chart gives us information about each feature's outliers.</p>
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
						<p>This information is used to cap the features' values</p>
						<pre>
							<code>
	train_complet['TotalBsmtSF'] = train_complet['TotalBsmtSF'].clip(105,2077)
							</code>
						</pre>
						<p>After having been capped, most of the features observe a rise in their correlation with the target feature. Indeed, for example, for the TotalBsmtSF feature, with a simple linear regression the R² score increases from 37,5% to 42%.</p>
						<div class="row mb-0">
							<div class="col-lg-6 col-md-6 col-sm-12 img-frame">
								<img class="image img-fluid" src="img/house-prices/TotalBsmtSF-rsquared-before.PNG" alt="">
							</div>
							<div class="col-lg-6 col-md-6 col-sm-12 img-frame">
								<img class="image img-fluid" src="img/house-prices/TotalBsmtSF-rsquared-after.PNG" alt="">
							</div>
						</div>
					</div>
					<div class="section-top-border">
						<h2>Correction of target feature's distribution</h2>
						<p>The target feature &quot;SalePrice&quot; has to be correctly distributed, the np.log1p() function offers the best correction. We can see here the effects of the np.log1p() function on the SalePrice feature distribution, before and after the transformation :</p>
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
						<p>The continuous features can then be scaled. The methods used will be presented later.</p>
						<pre>
							<code>
	quantitative = ['LotFrontage','LotArea','YearBuilt','YearRemodAdd','MasVnrArea','BsmtFinSF1','BsmtFinSF2','BsmtUnfSF','TotalBsmtSF','1stFlrSF','2ndFlrSF','GrLivArea','GarageYrBlt','GarageArea','WoodDeckSF','OpenPorchSF','EnclosedPorch','ScreenPorch', 'GarageArea', 'GrLivArea', '1stFlrSF', 'TotalBsmtSF']
	for df in ['X_train','X_test','submission']:
		df = ownLibrary.scale_features_in_df(df, quantitative, scaleMethod)
							</code>
						</pre>

					</div>
					<div class="section-top-border">
						<h2>Export of the modified datasets for following notebooks</h2>
						<p>The modified datasets are exported to csv. The following notebooks will now work on it without having to prepare again the data up to this waypoint.</p>
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
						<p>A hand-written function allows the testing of different combinations of feature transformation methods.</br>
						Here we find the different <b>scaling methods</b> that can be applied to the dataset prepared earlier :
							<ul class="unordered-list list-margin-left">
							    <li>No scaling</li>
							    <li>New value = (value - feature&#39;s min value) / (feature&#39;s max value - feature&#39;s min value)</li>
							    <li>New value = value / feature&#39;s max value</li>
							    <li>New value = (value - feature&#39;s mean value) / feature&#39;s standard deviation</li>
							    <li>New value = preprocessing.StandardScaler() function</li>
							</ul>
						</p>
						<p>
						Another hand-written function allows the testing of different feature transformation methods :
							<ul class="unordered-list list-margin-left">
							    <li>No modification of the feature</li>
							    <li>A data tree regressor finds bins which are the most correlated to the target feature</li>
							    <li>Polynomial transformations of different orders</li>
							</ul>
						</p>
						<p>The different results can then have their correlation with the target feature tested. A data frame give us the different scores and allows to chose the best method for each feature.</br>

						</p>
					</div>
					<div class="section-top-border">
						<h2>Data frame comparison methods</h2>
						<p>The two previously described functions produce a data frame containing the different R&sup2; scores. The following data frames are a shortened version of the complete one with fewer features and fewer scale methods concerned. </br>
						The LotArea feature is an interesting one. The "natural" correlation (if no transformation at all) with the target feature SalePrice presents a R² of 8.54%. The data tree regressor manages to create bins that have a correlation of 20.20% which is a great improvement. The polynomial regression also improves the R² but not as much as the data tree regressor method.</br>
						The second table indicates that these results can be improved again by scaling the feature before the transformations. The best results in the competition were obtained without feature scaling but with a large recourse to binning and polynomial regression. 
						</p>
						<span><b>Different transformations with non-scaled data</b></span>
						<div class="progress-table-wrap mb-30">
							<div class="progress-table">
							    <div class="table-head">
							      <div class="serial">Non-Scaled</div>
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
						<span><b>Different transformations with scaled data</b></span>
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
						<p>A parameter of the data tree regressor bins identifier function allow the printing of the bins as a python object. This object will later be used to replace the values of the different concerned features with another hand-written function.</p>
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
					<h2>Categorical features regroupment method</h2>
						<p>The method used to regroup categorical feature is based on a boxplot study. The boxplot show the correlation with the target feature for each state of a particular categorical feature. The similar states of this feature are then regrouped together.</br>
						Here is an example with the BsmtCond feature. On the following picture, the correlation between each state of the feature and the target feature is represented with a boxplot. The blue boxplot and the brown won't be regrouped, because they aren't similar to any of the other boxplot. The last three states (eNa for no basement, Fa and Po) have more similar boxplots, so they will be regrouped together.
						</p>
						<div class="img-frame">
							<img class="image img-fluid img-inpost" src="img/house-prices/BsmtCond-regroup.PNG" alt="">
						</div>
						<p>At the end of the study for each feature, another object python gives the list of states that will be regrouped later.</p>
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
						<h1>Modeling</h1>
						<p>Now that features have been analyzed and transformation methods chosen, the modeling part can start.</p>
					</div>
					<div class="section-top-border">
						<h2>Transformation based on the previous study</h2>
						<p>If the data preparation notebook hasn&#39;t done it, the continuous features are firstly scaled according to the method previously identified. Different lists of features are set for the rest of the process. Here, some continuous features are placed in lists for features which will be scaled (scaleMethod1 and 3) while some won't be scaled (scaleMethod0). We also retrieve the features which need a binning with the data tree regressor and those which need a polynomial transformation of order 2 or 3. The "ignore" list will be used by the dichotomization function.</p>
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
						<span><b>The scaling function allows us to choose the method that will be used</b></span>
						<pre>
							<code>
	def scale_features(dataset, features, scaleMethod) :
	    from sklearn import preprocessing
	    if (features == [] or features == ''):
	        features = dataset.columns
	    df = copy.deepcopy(dataset)
	    
	    if(scaleMethod == 0):
	        return df
	    
	    if(scaleMethod == 1):
	        for var in df[features] :
	                df[var] = (df[var]-df[var].min()) / (df[var].max()-df[var].min())
	    
	    if(scaleMethod == 2):
	        for var in df[features] :
	                df[var]=df[var]/df[var].max()
	                
	    if(scaleMethod == 3):
	        for var in df[features] :                
	                df[var] = (df[var]-df[var].mean()) / df[var].std()
	                
	    if(scaleMethod == 4):
	        df = preprocessing.StandardScaler().fit(df[features]).transform(df[features])
	        df = pd.DataFrame(data=df[0:,0:],    
	                      index=dataset.index,    
	                      columns=dataset[features].columns)
	    
	    return df
							</code>
						</pre>
						<span><b>Performs the scale tranformation</b></span>
						<pre>
							<code>
	X_train = ownLibrary.scale_features(X_train, scaleMethod1, 1)
	X_test = ownLibrary.scale_features(X_test, scaleMethod1, 1)
	submission = ownLibrary.scale_features(submission, scaleMethod1, 1)
							</code>
						</pre>
						<p>The states of categorical features are regrouped and the continuous features concerned are binned according to the data tree regressor bins. The regroupments are performed by a hand-written function. The function loops over a dataset's features. If a feature is in one of the python objects which define the regroupment, the regroupment is done.</p>
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
						<p>A group of new features can be created from the existing ones. For example, the number of fireplaces and their quality are combined to form one unique feature.</p>
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
						<p>A short hand-written function allows us to dichotomize a given dataset ignoring specified features. The ignored features are the continuous ones which haven&#39;t been binned, plus those which will undergo a polynomial transformation and a few others, such as the target feature.</p>
						<span><b>The function that performs the dichotomization</b></span>
						<pre>
							<code>
    def dichotomize_dataset(dataset, columnsToNotDicho):
        dichotomizeDF = pd.DataFrame()
        for column in dataset :
            if(column not in columnsToNotDicho):
                dummies = pd.get_dummies(dataset[column], prefix=column)
                dummies.reset_index(drop=True, inplace=True)
                dichotomizeDF.reset_index(drop=True, inplace=True)
                dichotomizeDF = pd.concat([dichotomizeDF, dummies], axis=1, sort=True)
            else:
                dichotomizeDF[column] = dataset[column]
        return dichotomizeDF
							</code>
						</pre>
						<span><b>Perform the dichotomization</b></span>
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
						<p>A hand-written function from the custom library performs a polynomial transformation on a list of features of a given dataset with a given polynomial order. The function returns the transformed dataset. Here a first polynomial transformation of order 2 on the concerned features is performed. The resulting dataset is then used for a second transformation of order 3 for another list of features defined at the begining of the notebook.</p>
						<span><b>Perform the polynomial transformation</b></span>
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
						<h2>Harmonization of features present in each dataset</h2>
						<p>At this stage, some datasets can have more features than others. For example, the lot area feature was transformed into several bins, but the train dataset has no bin number 1 of this feature. The harmonization inserts this feature/bin in the train dataset and fills it with 0 values (as the feature is a dichotomized one), indicating that no observations are concerned by this feature.</br>
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
						<h2>Feature selection</h2>
                        <p>Several feature selection methods are used to detect effective combinations of features for the modeling part. The Stepwise provides a solution that presents a small set of features for a good accuracy. On the other hand, the Recursive feature addition maximizes the R² but uses more features.</p>
                        <h3>Stepwise</h3>
						<p>A stepwise function found on the web leads to good accuracy modelings. The function has been included in the custom library and can be found at this address : <a href="https://datascience.stackexchange.com/questions/24405/how-to-do-stepwise-regression-using-sklearn/24447#24447">Stepwise function's source</a></br>
                        The stepwise selection results in approximately 40 features, depending on the combination of scaling and transformation methods used. The R² score reaches around 90 %.</p>
						<span><b>Perform a stepwise feature selection</b></span>
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
						
                        <h3>Recursive feature addition</h3>
                        <p>
                            The recursive feature addition is the most adapted to maximize the R² which reaches around 91,5 % of accuracy with around 90 features used. The function has been modified and included in the custom library from this post : <a href="https://heartbeat.fritz.ai/hands-on-with-feature-selection-techniques-hybrid-methods-b93b1b06d3a5">Recursive feature addition function's source</a>
                        </p>
					</div>
					<div class="section-top-border">
						<h2>Launching modeling</h2>
						<p>The GridSearchCV library allows us to find the best parameters for a group of models. When these parameters are found, the features selected by the stepwise are transmitted to a hand-written function than runs several models fitted with the training data. The predicted values for each of these models are stored in two data frames, one for the training dataset predicted values, and one for the test dataset.</p>
						<p>A last hand-written function prints the results of these modelings for the training and test datasets, giving information about overfitting or underfitting presence.</p>
						<span><b>Define the features and models to use</b></span>
						<pre>
							<code>
	y = 'SalePrice_log'
	models = {
	    'fa' : {
	        'label' : 'Forêt aléatoire',
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
						<span><b>Perform the modeling</b></span>
						<pre>
							<code>
	for model in models :
	    models[model]['function'].fit(train_rwrk[var_stepwise], train_rwrk[y])
	predictions_train = ownLibrary.runModels1DS(train_rwrk, 'train', var_stepwise, y, models)
	predictions_test = ownLibrary.runModels1DS(test_rwrk, 'test', var_stepwise, y, models)
							</code>
						</pre>
                    </div>
                    <div class="section-top-border">
                        <h1>Results</h1>
						<span><b>Printing the results</b></br>Here are the results based on the Recursive feature addition</span>
						<pre>
							<code class="python">
    ownLibrary.afficheResults(predictions_train, predictions_test, 'SalePrice', models)

    ---------- K-Nearest Neighbors ----------

        Train : R² = 61.2 % 
        Test : R² = 56.2 % 

    ---------- Decision Tree Regressor ----------

        Train : R² = 98.3 % 
        Test : R² = 79.3 % 

    ---------- Linear Regression ----------

        Train : R² = 91.5 % 
        Test : R² = 91.7 % 

    ---------- Random Forest ----------

        Train : R² = 97.5 % 
        Test : R² = 85.7 % 

    ---------- Ridge Regression ----------

        Train : R² = 91.4 %
        Test : R² = 91.5 %
							</code>
						</pre>
						<p>The 91,7 % R² with the Multivariate linear regression is currently the best score obtained by the study. The submission on Kaggle.com ranks the study at 1,741, so in the first 33%. 
                    </p>
                </div>
                <div class="section-top-border">
                    <h1>Summary of study's steps</h1>
                    <p>Here is a summary of the steps that led to the result :</p>
					<div class="row grid">
						<div class="single-work col-lg-6 col-md-6 col-sm-12 wow fadeInUp" data-wow-duration="2s">
                            <span><b>Step 1 - Exploratory Data Analysis</b></span>
							<ul class="unordered-list unordered-list-inpost list-margin-left">
					    		<li>Split dataset in train and test</li>
					    		<li>Replacement of missing values</li>
					    		<li>Creation of new features</li>
					    		<li>Feature deletion</li>
					    		<li>Outlier correction</li>
					    		<li>Target feature distribution correction</li>
				    		</ul>
						</div>
						<div class="single-work col-lg-6 col-md-6 col-sm-12 wow fadeInUp" data-wow-duration="2s">
                            <span><b>Step 2 - Best transformation research</b></span>
							<ul class="unordered-list unordered-list-inpost list-margin-left">
					    		<li>Comparison of different scale methods</li>
					    		<li>Comparison of different transformations
                                <ul>
                                    <li>Feature left continuous</li>
                                    <li>Binning based on a data tree regressor</li>
                                    <li>Polynomial transformation</li>
                                </ul>
                                </li>
                                <li>Categorical feature grouping</li>
				    		</ul>
						</div>
                    </div>
                    </hr>
                    <div class="row grid">
                        <div class="single-work col-lg-6 col-md-6 col-sm-12 wow fadeInUp" data-wow-duration="2s">
                            <span><b>Step 3 - Performing transformation</b></span>
                            <ul class="unordered-list unordered-list-inpost list-margin-left">
                                <li>Grouping of feature states</li>
                                <li>Creation of new features</li>
                                <li>Dichotomization</li>
                                <li>Polynomial transformation</li>
                            </ul>
                        </div>
						<div class="single-work col-lg-6 col-md-6 col-sm-12 wow fadeInUp" data-wow-duration="2s">
                            <span><b>Step 4 - Modeling</b></span>
							<ul class="unordered-list unordered-list-inpost list-margin-left">
					    		<li>Feature selection
                                    <ul>
                                        <li>Stepwise</li>
                                        <li>Recursive feature addition</li>
                                        <li>Recursive feature elimination</li>
                                    </ul>
                                </li>
                                <li>GridSearchCV</li>
					    		<li>Performing modeling</li>
                                <li>Analysing results</li>
				    		</ul>
						</div>
					</div>
                    <h1>Project's GitHub Repository</h1>
                    <div class="img-frame margin-top-20">
                        <a href="https://github.com/Jdecot/House-prices" target="_blank">
                            <img class="img-fluid vertical-align-middle max-width-40" src="img/brand/originaux/github.png" alt="GitHub logo">
                        </a>
                    </div>
				</div>

				</div>
			</div>
		</div>
	</section>
	<!-- End Portfolio Details Area -->

	<?php include('layouts/contact-section.php'); ?>

	<?php include('layouts/footer.php'); ?>

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