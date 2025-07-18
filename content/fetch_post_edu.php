<?php
require_once "../includes/connection.php";
require_once("../includes/config.inc.php");
include("../includes/useAVclass.php");
require_once "../includes/functions.inc.php";
if(isset($_POST['id']))
{
$need_query=mysql_query("SELECT `post_need_qual` FROM `post_mst` WHERE `post_id`=$id");
$need=mysql_fetch_array($need_query);
if($need['post_need_qual']==1)
{
$query="SELECT `Qualification_list` FROM `qualification_mst` WHERE `qualification_id`in(SELECT `post_qualification_id` FROM `p_post_qualification` WHERE `post_id`='$id' order by `Qualification_list`)";
$res=mysql_query($query);
$no=mysql_num_rows($res);
if($no>0)
{
echo '<tr id="tab_logic_postrow">
<td><select name="post_grad_exam" class="form-control" onChange="" id="post_grad_exam"><option value="">Select Post Graduation</option>';
while($data = mysql_fetch_array($res, MYSQL_ASSOC))
  {
@extract($data);
?>

<option><?php echo $Qualification_list;?></option>
<?php

}
echo '</select></td>';

?>

<td><input type="text" name="post_exam_board"  onblur="return alphanumeric(this)" value=""  class="form-control" /><span id="post_exam_board" class="validation_error"></span></td>
                          <td><select name="post_exam_month" id='gMonth1' class="form-control">
                             <option value="">--Select Month--</option>
                            <option value="1">Janaury</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                          </select></td>


<td>    <select id="" name="post_exam_year" class="form-control" onChange="">
                            <option value="2012">Select</option>
                            <option value="2015">2015</option>
                            <option value="2014">2014</option>
                            <option value="2013">2013</option>
<option value="2012">2012</option>
    <option value="2011">2011</option>
    <option value="2010">2010</option>
        <option value="2009">2009</option>
        <option value="2008">2008</option>
      <option value="2007">2007</option>
      <option value="2006">2006</option>
      <option value="2005">2005</option>
      <option value="2004">2004</option>
      <option value="2003">2003</option>
      <option value="2002">2002</option>
      <option value="2001">2001</option>
      <option value="2000">2000</option>
      <option value="1999">1999</option>
      <option value="1998">1998</option>
      <option value="1997">1997</option>
      <option value="1996">1996</option>
      <option value="1995">1995</option>
      <option value="1994">1994</option>
      <option value="1993">1993</option>
      <option value="1992">1992</option>
      <option value="1991">1991</option>
      <option value="1990">1990</option>
      <option value="1989">1989</option>
      <option value="1988">1988</option>
      <option value="1987">1987</option>
      <option value="1986">1986</option>
      <option value="1985">1985</option>
      <option value="1984">1984</option>
      <option value="1983">1983</option>
      <option value="1982">1982</option>
      <option value="1981">1981</option>
      <option value="1980">1980</option>
      <option value="1979">1979</option>
      <option value="1978">1978</option>
      <option value="1977">1977</option>
      <option value="1976">1976</option>
      <option value="1975">1975</option>
      <option value="1974">1974</option>
      <option value="1973">1973</option>
      <option value="1972">1972</option>
      <option value="1971">1971</option>
      <option value="1970">1970</option>
      <option value="1969">1969</option>
      <option value="1968">1968</option>
      <option value="1967">1967</option>
      <option value="1966">1966</option>
      <option value="1965">1965</option>
      <option value="1964">1964</option>
      <option value="1963">1963</option>
      <option value="1962">1962</option>
      <option value="1961">1961</option>
      <option value="1960">1960</option>
                          </select></td>
                          <td><input type="text" name="post_exam_subj" onblur="return alphanumeric(this)" value="" class="form-control" /><span id="post_exam_subj" class="validation_error"></span></td>
                    <td>
             <select name="post_exam_div"  class="form-control">          
<option value="">-Select-</option>
<option value="First">First</option>
<option value="Second">Second</option>
<option value="Third">Third</option>
</select>  </td>


                    


                          <td><input type="text"  id="" name="post_exam_perc" onblur="return percentage(this)" value="" class="form-control" maxlength=3 /><span id="post_exam_div" class="validation_error"></span></td>
</tr>

<?php
}
}
else
{
  echo "delete";
}
}
?>




