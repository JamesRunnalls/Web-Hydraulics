<!doctype html>
<html>
<head>
<meta name="description" content="Hydraulics Engineering">
<meta name="author" content="James Runnalls">
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<script src="js/d3.v4.min.js"></script>
<script type="text/javascript"
  src="js/dygraph.min.js"></script>
<script type="text/javascript"
  src="js/synchronizer.js"></script>
<link rel="stylesheet" src="css/dygraph.css" />  
<script src="js/jquery.min.js"></script>
<link href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css' rel='stylesheet' type='text/css'>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="apple-touch-icon" sizes="180x180" href="/img/logo/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/img/logo/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/img/logo/favicon-16x16.png">
<link rel="manifest" href="/img/logo/site.webmanifest">
<link rel="mask-icon" href="/img/logo/safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#2b5797">
<meta name="msapplication-config" content="/img/logo/browserconfig.xml">
<meta name="theme-color" content="#ffffff">
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<style> td {text-align: left;} th {text-align: left;}</style>
<script type="text/x-mathjax-config">
  MathJax.Hub.Config({
    tex2jax: {inlineMath: [["$","$"],["\\(","\\)"]]}
  });
</script>
<script type="text/javascript" src="js/MathJax/MathJax.js?config=TeX-AMS_HTML-full"></script>

<title>Equations</title>
</head>
    
<body>
    
<div style="width:90vw;margin:auto;">


<!-- Mannings Eqution -->

<h5>Mannings Equation</h5>	

 $$ Q = \frac{1}{n}A \left( \frac{A}{P} \right) ^{\frac{2}{3}}\sqrt S $$

 Q = Flow rate (m3/s) <br>
 n = Mannings n <br>
 A = Cross sectional area of flow (m2) <br>
 P = Wetted Perimeter (m) <br>
 S = Slope (m/m) <br>

<br><b>Reference</b>
 Manning, R. (1891). "On the flow of water in open channels and pipes". Transactions of the Institution of Civil Engineers of Ireland. 20: 161–207. <br><br>
 
<!-- Reynolds No -->

<h5>Reynolds No</h5>	

 $$ Re = \frac{uL}{\nu} $$

 Re = Reynolds number <br>
 u = Velocity (m/s) <br>
 L = Characteristic length (m) - diameter/ equaivalent diameter for circular/ rectangular condiuts. <br>
&nu; = Kinematic viscosity of fluid (m2/s) <br>

<br><b>Reference</b>
 Reynolds, Osborne (1883). "An experimental investigation of the circumstances which determine whether the motion of water shall be direct or sinuous, and of the law of resistance in parallel channels". Philosophical Transactions of the Royal Society. 174 (0): 935–982. doi:10.1098/rstl.1883.0029. JSTOR 109431. <br><br>

 <!-- Froude No -->

<h5>Froude No</h5>	

 $$ Fr = \frac{u}{\sqrt{gL}} $$

Fr = Froude number <br>
 u = Velocity (m/s) <br>
 L = Characteristic length (m) - diameter/ equaivalent diameter for circular/ rectangular condiuts. <br>
g = Acceleration due to gravity (m/s2) <br>

<br><b>Reference</b>
 Frank M. White, Fluid Mechanics, 4th edition, McGraw-Hill (1999), 294. <br><br>

 <!-- Swamee-Jain Equation -->

<h5>Swamee-Jain Equation</h5>	


$$ f = \frac{0.25}{log_{10} \left( \frac{\epsilon /D}{3.7} + \frac{5.74}{Re^0.9} \right) ^2} $$

f = Darcy friction factor <br>
&epsilon; = Effective roughness height (m) <br>
D = Diameter (m) <br>
Re = Reynolds number <br>

<br><b>Reference</b>
 Swamee, P.K.; Jain, A.K. (1976). "Explicit equations for pipe-flow problems". Journal of the Hydraulics Division. 102 (5): 657–664. <br><br>


 <!-- Colebrook-White Equation -->

<h5>Colebrook-White Equation</h5>	


$$ \frac{1}{\sqrt f} = -2log_{10} \left( \frac{\epsilon}{3.7D} + \frac{2.51}{Re \sqrt f} \right) $$

f = Darcy friction factor <br>
&epsilon; = Effective roughness height (m) <br>
D = Hydraulic diameter (m) <br>
Re = Reynolds number <br>

<br><b>Reference</b>
Colebrook, C F (1939). "Turbulent flow in pipes, with particular reference to the transition region between the smooth and rough pipe laws". Journal of the Institution of Civil Engineers. 11 (4): 133–156. doi:10.1680/ijoti.1939.13150. ISSN 0368-2455. <br><br>


<!-- Darcy-Weisbach Equation -->

<h5>Darcy-Weisbach Equation</h5>	


$$ h_{L} = f \frac{L}{D} \frac{V^2}{2g} + K \frac{V^{2}}{2g} $$

h<sub>L</sub> = Head loss (m) <br>
f = Darcy friction factor <br>
K = Minor loss factor <br>
L = Pipe length (m) <br>
D = Hydraulic diameter (m) <br>
V = Average flow velocity (m/2) <br>
g = Acceleration due to gravity (m/s2) <br>

<br><b>Reference</b>
Brown, Glenn. "The Darcy–Weisbach Equation". Oklahoma State University–Stillwater. <br><br>


<!-- Minor Losses from Pipe Size Changes -->

<h5>Minor Losses from Pipe Size Changes</h5>	

<br><b>Minor head loss equation</b><br><br>
$$ h_{M} = K \frac{V^2}{2g} $$

<b>Square Reduction </b><br><br>

Re<sub>1</sub> < 2500

$$ K = \left( 1.2 + \frac{160}{Re_{1}} \right) \left[ \left( \frac{D_{1}}{D_{2}} \right)^4 -1 \right] $$

Re<sub>1</sub> > 2500

$$ K = \left( 0.6 + 0.48 f_{1} \right) \left( \frac{D_{1}}{D_{2}} \right)^2 \left[ \left( \frac{D_{1}}{D_{2}} \right)^2 -1 \right] $$

<b>Tapered Reduction </b><br><br>

For 45&deg; < &theta; < 180&deg;, Multiply K from "square reduction" by:
$$ \sqrt{\sin\left(\frac{\theta}{2}\right)} $$
​
​For &theta; < 45&deg;, Multiply K from "square reduction" by:
$$ 1.6\sin\left(\frac{\theta}{2}\right) $$

<b>Rounded Reduction </b><br><br>

$$ K=\left(0.1+\frac{50}{Re_{1}}\right)\left[\left(\frac{D_{1}}{D_{2}}\right)^{4}-1\right] $$

<b>Square Expansion </b><br><br>

For Re<sub>1</sub> < 4000
$$ K=2\left[1-\left(\frac{D_{1}}{D_{2}}\right)^{4}\right] $$

For Re<sub>1</sub> > 4000
$$ K=\left(1+0.8f_{1}\right)\left[1-\left(\frac{D_{1}}{D_{2}}\right)^{2}\right]^{2} $$​​

<b>Tapered Expansion </b><br><br>

For &theta; > 45&deg; Use K for Square Expansion <br><br>

For &theta; < 45&deg; Multiply K for a Square Expansion by,
$$ 2.6\sin\left(\frac{\theta}{2}\right) $$

<b>Rounded Expansion </b><br><br>

Use K for square expansion. <br><br>

h<sub>M</sub> = Head loss - minor losses (m) <br>
K = Minor loss coefficient <br>
Re<sub>1</sub> = Reynolds number upstream pipe <br>
f<sub>1</sub> = Darcy friction factor upstream pipe <br>
L = Pipe length (m) <br>
D = Internal pipe diameter (m) <br>
D<sub>1</sub> = Upstream pipe diameter (m) <br>
D<sub>2</sub> = Downstream pipe diameter (m) <br>
V = Average flow velocity (m/2) <br>
&theta; = Taper angle (degrees) <br>

<br><b>Reference</b>
Native Dynamics (2012). Pressure Loss from Fittings – Expansion and Reduction in Pipe Size – Neutrium. [online] Neutrium.net. Available at: https://neutrium.net/fluid_flow/pressure-loss-from-fittings-expansion-and-reduction-in-pipe-size/ [Accessed 18 Sep. 2018]. <br><br>


<!-- Bernoulli's Equation -->

<h5>Bernoulli's Equation</h5>	

$$ H = z + \frac{p}{\rho g} + \frac{V^2}{2g} $$

H = Energy Head (m) <br>
z = Elevation of point above reference plane (m) <br>
P = Pressure at given point (N/m2) <br>
&rho; = Density of the fluid (kg/m3) <br>
V = Average flow velocity (m/2) <br>
g = Acceleration due to gravity (m/s2) <br>

 <br><br>


<!-- Sequent Depths in Closed Conduits -->

<h5>Sequent Depths in Closed Conduits</h5>	

<br><b>Rectangular Section</b><br><br>

If Fr<sub>1</sub> < (Fr<sub>1</sub>)<sub>T</sub> (Complete jump forms)

$$ y_{2} = y'_{2} = \frac{y'_{1}}{2} \left( \sqrt{1 + 8 Fr_{1}^{2}} - 1 \right) $$

If Fr<sub>1</sub> &ge; (Fr<sub>1</sub>)<sub>T</sub> (Incomplete jump forms)

$$ y_{2} = y'_{2} = \frac{1}{2} + \left( Fr_{1} ^{2} + \frac{1}{2} \right) y'{}_{1} ^{2} - Fr_{1}^{2} y'{}_{1} ^{3} $$

Transitional Froude Number

$$ (Fr_{1})_{T} = \sqrt{\frac{1 + y'_{1}}{2y'{}_{1}^2}} $$

Froude Number

$$ Fr_{1} = \frac{Q}{\sqrt{gB^{2}y_{1}^{3}}} $$

<b>Circular Section</b><br><br>

If Fr<sub>1</sub> < (Fr<sub>1</sub>)<sub>T</sub> (Complete jump forms) <br><br>

This needs to be solved iteratively to find Sd.

$$ Fr_{1}^{2} = \frac{T'_{1}A'_{2} \left[ \left( \overline{z}A \right)'_{2} - \left( \overline{z}A \right)'_{1} \right]}{A'{}_{1}^{2} \left( A'_{2} - A'_{1} \right)} $$

If Fr<sub>1</sub> &ge; (Fr<sub>1</sub>)<sub>T</sub> (Incomplete jump forms)

$$ y_{2} = y'_{2} = 1 + \frac{1}{T'_{1}A'{}_{f}^{2}} \left( Fr_{1}^{2} A'{}_{1}^{2} \left( A'_{f} - A'_{1} \right) - T'_{1} A'_{f} \left[ \left( \overline{z}A \right)'_{f} - \left( \overline{z}A \right)'_{1}  \right] \right) $$

Transitional Froude Number

$$ (Fr_{1})_{T} = \sqrt{ \frac{T'_{1}A'_{f} \left[ \left( \overline{z}A \right)'_{f} - \left( \overline{z}A \right)'_{1} \right]}{A'{}_{1}^{2} \left( A'_{f} - A'_{1} \right)} } $$

Froude Number

$$ Fr_{1} = \frac{Q}{\sqrt{ \frac{gB^{2}D^{3}A'{}_{1}^{3}}{T'_{1}}}} $$

Internal Flow Angle

$$ \theta = 2 cos^{-1} \left( 1 - 2y' \right) $$

Dimensionless Top Width

$$ T' = \frac{T}{B} = sin \left( \frac{\theta}{2} \right) $$

Dimensionless Area

$$ A' = \frac{A_{i}}{D^{2}} = \frac{1}{8} \left( \theta - sin \theta \right) $$

Dimensionless Centroid-Area

$$ \left( \overline{z}A \right)' = \frac{\overline{z}A}{D^{3}} = \frac{1}{24} \left[ 3sin\left(\frac{\theta}{2} \right) - sin^{3}\left(\frac{\theta}{2} \right) - 3\frac{\theta}{2}cos\left(\frac{\theta}{2} \right)\right] $$

<b>Notation</b><br>
y = Fluid depth (m) <br>
y' = Dimentionless ratio of fluid depth <br>
Fr = Froude number <br>
(Fr)<sub>T</sub> = Transitional froude number <br>
Q = Flow rate (m3/s) <br>
g = Acceleration due to gravity (m/s2) <br>
B = Span of conduit (m);
T = Free surface width (m) <br>
T' = Dimentionless ratio of free surface width <br>
A = Cross sectional area (m2) <br>
A'= Dimensionless cross sectional area (m2) <br>
D = Rise of conduit (m) <br>
<SPAN STYLE="text-decoration:overline">z</SPAN>  = Distance from the water surface to the centroid of cross-sectional area (m) <br>
&theta; = Internal flow angle (rad)

<br><b>Subscripts</b><br>
1 = Parameter at input depth <br>
2 = Parameter at sequent depth <br>
f = Parameter at pipe full depth <br>

<br><b>Reference</b>
J. Lowe, Nathan & Hotchkiss, Rollin & James Nelson, E. (2011). Theoretical Determination of Sequent Depths in Closed Conduits. Journal of Irrigation and Drainage Engineering. 137. 801-810. 10.1061/(ASCE)IR.1943-4774.0000349.  <br><br>


<!-- Direct Step Method -->

<h5>Direct Step Method</h5>	

<br><b>Distance between changes in depth</b>

$$ \Delta x = \frac{E_{2}-E_{1}}{S_{0}- \overline{S_{f}}} $$

<b>Specific Energy </b>

$$ E = y + \frac{V^{2}}{2g} $$ 

<b>Friction Slope</b>

$$ S_{f} = \left( \frac{nQ}{A \frac{A}{P}^{2/3}} \right)^{2} $$

<b>Average Friction Slope</b>

$$ \overline{S_{f}} = \frac{S_{f2}+S_{f1}}{2} $$

&Delta;x = Distance between two depths <br>
E<sub>1</sub> = Specfic energy at first point (m) <br>
E<sub>2</sub> = Specfic energy at second point (m) <br>
S<sub>0</sub> = Bottom slope of conduit (m/m) <br>
<SPAN STYLE="text-decoration:overline">S</SPAN><sub>f</sub> = Average friction slope (m/m) <br>
S<sub>f1</sub> = Friction slope at first point (m/m) <br>
S<sub>f2</sub> = Friction slope at second point (m/m) <br>
y = Fluid depth at point (m) <br>
V = Average velocity at point (m/s) <br>
g = Acceleration due to gravity (m/s2) <br>
n = Mannings n <br>
Q = Flow rate (m3/s) <br>
A = Cross sectional area at point (m2) <br>
P = Wetted perimiter (m) <br>

<br><b>Reference</b>
CHOW, V. T. (1959). Open-channel hydraulics. New York, McGraw-Hill. <br><br>


<!-- Hydraulic Jump Length -->

<h5>Hydraulic Jump Length</h5>	

<br><b>Rectangular Section</b><br><br>

Flat Slope (Type A) - Start of jump in downstream section

$$ L^{*}_{j} = 220(y_{1}) \left( tanh \left( \frac{Fr_{1}-1}{22} \right) \right) $$

Jump over slope break (Type B) - Start of jump in upstream section end of jump in downstream section <br><br>

&nbsp; &nbsp; If Fr<sub>1</sub> > Fr<sub>1t</sub>

$$ L_{j} = L^{*}_{j} $$

&nbsp; &nbsp; If Fr<sub>1</sub> &le; Fr<sub>1t</sub>

$$ L_{j} = h_{2} \left[ \frac{7}{3} \left( 2+\left[6E * exp(1-6E) \right] \right) - \frac{1}{20} \left( 1+5\left[ 6E * exp(1-6E) \right] \right) \left(Fr_{1} -2 \right) \right] $$

&nbsp; &nbsp; Where

$$ E = \frac{\left( h_{2} - z_{1} \right)}{h_{2}} $$

&nbsp; &nbsp; Transitional Froude No

$$ Fr_{1t} = 11.3 \left( 1 - \frac{2}{3} \left[ \frac{h_{2} - z_{1}}{h_{2}} \right] \right) $$

Sloped Culvert (Type C) - Jump contained in upstream section

$$ L_{j} = L^{*}_{j} * exp \left( -\frac{4}{3} \theta\right) $$

<b>Circular Section</b><br><br>

Flat Slope (Type A) - Start of jump in downstream section

$$ L^{*}_{j} = 6y_{2} $$

Jump over slope break (Type B) - Start of jump in upstream section end of jump in downstream section <br><br>

&nbsp; &nbsp; If Fr<sub>1</sub> > Fr<sub>1t</sub>

$$ L_{j} = L^{*}_{j} $$

&nbsp; &nbsp; If Fr<sub>1</sub> &le; Fr<sub>1t</sub>

$$ L_{j} = h_{2} \left[ \frac{7}{3} \left( 2+\left[6E * exp(1-6E) \right] \right) - \frac{1}{20} \left( 1+5\left[ 6E * exp(1-6E) \right] \right) \left(Fr_{1} -2 \right) \right] $$

&nbsp; &nbsp; Where

$$ E = \frac{\left( h_{2} - z_{1} \right)}{h_{2}} $$

&nbsp; &nbsp; Transitional Froude No

$$ Fr_{1t} = 11.3 \left( 1 - \frac{2}{3} \left[ \frac{h_{2} - z_{1}}{h_{2}} \right] \right) $$

Sloped Culvert (Type C) - Jump contained in upstream section

$$ L_{j} = L^{*}_{j} * exp \left( -\frac{4}{3} \theta\right) $$

L*<sub>j</sub> = Length of hydraulic jump on flat slope (m) <br>
L<sub>j</sub> = Length of the hydraulic jump on a sloping channel (m) <br>
y<sub>1</sub> = Sequent depth at the upstream end of the hydraulic jump (m) <br>
y<sub>2</sub> = Sequent depth at the downstream end of the hydraulic jump (m) <br>
Fr<sub>1</sub> = Froude number at the upstream end of the hydraulic jump <br>
&theta; = Channel angle of repose (rad) <br>
z<sub>1</sub> = Distance from the invert of the flat part of the channel to the channel invert at the beginning of the jump (m) <br>
h<sub>2</sub> = Depth of water on a flat slope after the jump (m) <br>

<br><b>Reference</b>
Bradley, J.N., Peterka, A. J., “Hydraulic Design of Stilling Basins,” Journal of A.S.C.E., Hydraulic Engg, 83 (5), 1401-1406, 1957. <br>
Hager  WH  (1992).  “Energy  dissipators  and  hydraulic  jump”,  Kluwer Academic  Publications,  Dordrecht, The  Netherlands.  <br><br>


<!-- Headwater - Supercritical Entrance -->

<h5>Headwater - Supercritical Entrance</h5>	

<br><b>Unsubmerged Inlet</b> Q/AD<sup>0.5</sup> < 3.5

$$ \frac{HW_{i}}{D} = \frac{H_{c}}{D} + K \left[ \frac{Q}{AD^{0.5}} \right]^{M} - 0.5S $$

$$ \frac{HW_{i}}{D} = K \left[ \frac{Q}{AD^{0.5}} \right]^{M} $$

&nbsp; &nbsp; Specific head at critical depth

$$ H_{c} = d_{c} + \frac{V_{c}^{2}}{2g} $$

<br><b>Submerged Inlet</b> Q/AD<sup>0.5</sup> > 4.0

$$ \frac{HW_{i}}{D} = c \left[ \frac{Q}{AD^{0.5}} \right]^{2} + Y - 0.5S $$

HW<sub>i</sub> = Headwater for supercritical entrance (ft) <br>
H<sub>c</sub> = Specific head at critical depth (ft) <br>
d<sub>c</sub> = Critical depth (ft) <br>
V<sub>c</sub> = Average flow velocity at critical depth <br>
g = Acceleration due to gravity (m/s2) <br>
Q = Flow rate (ft3/s) <br>
A = Cross sectional area (ft2) <br>
D = Rise of conduit (ft) <br>
K, M, c, Y = Constants <br>

<br><b>Reference</b>
Thiele, Elizabeth Anne, "Culvert Hydraulics: Comparison of Current Computer Models" (2007). All Theses and Dissertations. 881. https://scholarsarchive.byu.edu/etd/881 <br><br>


<!-- Headwater - Subcritical Entrance -->

<h5>Headwater - Subcritical Entrance</h5>	

$$ HW = y + K \frac{V^{2}}{2g} $$

HW = Headwater for subcritical entrance (m) <br>
y = Fluid depth at entrance (m) <br>
K = Minor loss coefficient (m) <br>
V = Average flow velocity (m/2) <br>
g = Acceleration due to gravity (m/s2) <br>

<br><br><br>
    
 </div>   

</body>
</html>

