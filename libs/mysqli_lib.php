<?php
// @mysqli query class
// @author : Oni Victor
// @Date Created: Feb 2016
// @Date Updated: July 2016

class Mysqli_lib{
                  // define object storage for mysql class
                  private $mysqli_connection;
                  private $query_object;
                  private $query_statement ;
                  // put default values in the variables for database connect
                  public $mysqli_host = 'localhost';
                  public $mysqli_user = 'root';
                  public $mysqli_password = '';
                  public $mysqli_db = '';
    
    
// 1.) [connect()] function to connect to database
public function connect()
{
  $con=  mysqli_connect($this -> mysqli_host, $this -> mysqli_user, $this -> mysqli_password, $this -> mysqli_db);
  if(!$con)
  {
    die('Unable to connect to database [' . mysqli_connect_error(). ']');
  }
  else
  {
    mysqli_set_charset($con,'utf8'); // fix for storage of accented characters
    $this -> mysqli_connection = $con;
    return true;
  }
}


// 2.) [query] just query statement
public function query($query)
    {
          $result = mysqli_query($this->mysqli_connection,$query);
          return $result;
    }
    
    
// 3.) [query_data] // returns array of data from query
public function query_data($query)
{
  $results = array();
  $result = mysqli_query($this->mysqli_connection,$query);
  while ( $row = mysqli_fetch_assoc($result) )
  {
    $results[] = $row ;
  }
  return $results;
}
    
    
// 4.) [query_single_data] returns only single column result in a query
public function query_single_data($query)
{
  return $this->query_data($query)[0];
}
    
    
// 5.) [query_count] counts number of results in a query
public function query_count($sql)
{
  $result = mysqli_query($this->mysqli_connection,$sql);
  return mysqli_num_rows($result) ;
}
    
// 6.) [table_exist] checks if a mysqlk table exist in selected database   
public function table_exist($table_name)
{
        return $this->query("select 1 from $table_name") ? true : false ;
}
    
    
// 7.) [db_table_count] counts number of tables in a selected database
public function db_table_count($db = NULL)
{
        $database = $db ===NULL ? $this->default_dbase : $db ; 
    
        // if no db is null use default database we connected to
    
        $return = $this->query_single_data(
        "SELECT count(table_name) as $database FROM information_schema.tables WHERE table_schema = '$database'");
        return $return[$database];
}

// 8.) [get_field] get a particular field in a table 
public function get_field($query,$field)
{
        $data = $this->query_single_data($query);
        return $data[$field];
}
    
// 9.) [insert] insert into a mysql table  
public function insert($fields,$table_name)
{
        $fl = $this->convert_statement($fields);
        $f = $fl['fields'];
        $v = $fl['values'];
        return $this->query('INSERT INTO '.$table_name.'('.$f.')'.'VALUES ('.$v.')');
}
    
// 10.) [insert_ignore] insert into a mysql table and ignore errors    
public function insert_ignore($fields,$table_name)
{
        $fl = $this->convert_statement($fields);
        $f = $fl['fields'];
        $v = $fl['values'];
        return $this->query('INSERT IGNORE INTO '.$table_name.'('.$f.')'.'VALUES ('.$v.')');
}
    
// 11.) [delete] delete from a mysql table  
public function delete($where,$table_name)
{
    if(is_array($where)):
        $w = $this->convert_statement($where);
        $w = $w['where'] ;
        else:
        $w = $where;
        endif;
        return $this->query('DELETE FROM '.$table_name.' WHERE '.$w);
}
    
// 12.) [insert] update a record in a mysql table
public function update($set,$where,$table_name)
{
        
        if(is_array($where))
        {       
            $w = $this->convert_statement($where);
            $wr = $w['where'];
        }
        else
        {           
            $wr = $where;
        }
        
        // set
        if(is_array($set))
        {       
            $s = $this->convert_statement($set);
            $st = $s['set'];
        }
        else
        {           
            $st = $set;
        }
        
        return $this->query('UPDATE '.$table_name.' SET ' .$st.' WHERE '.$wr);
}
    
// 13.) [truncate] truncate a mysql table
public function truncate($table_name)
{
        return $this->query('TRUNCATE TABLE '.$table_name);
}
    
// 14.) [escape_string] escape a string for insert queries
public function escape_string($string)
{
        return mysqli_real_escape_string($this->mysqli_connection,$string);
}
    
// 15.) [get_id] get_id of the last insert query   
public function get_id()
{
        return mysqli_insert_id($this->mysqli_connection);
}
    
// 16.) [get_error] get mysql error
public function get_error()
{
        return mysqli_error($this->mysqli_connection);
}
    
// 17.) [table_record_count] count number of records in a mysql table 
public function table_record_count($table)
{
        $this->query_single_data(
        "SELECT count(*) as $table FROM $table LIMIT 1"
        );
        return $return[$table];
}
// 18.) [prepare] create prepared statements
public function prepare($sql,$values)
    {
      // Create a prepared statement
    $stmt = mysqli_stmt_init($this->mysqli_connection);
    if (mysqli_stmt_prepare($stmt,$sql))
        {
          // Bind parameters
            if(!is_array($values))
            {
              mysqli_stmt_bind_param($stmt,"s",$values);
            }
            else
            {
              foreach($values as $val):
              mysqli_stmt_bind_param($stmt,"s",$val);
              endforeach;
            }
          // Execute query
          return mysqli_stmt_execute($stmt);
        }
    }
    
// 19.) [close_connection] close current mysql connection
public function close_connection()
    {
        mysqli_close($this->mysqli_connection);
    }

// 20.) [batch_query] mysqli multi query
public function batch_query($file)
    {
        $query = file_get_contents($file);
        $result = mysqli_multi_query($this->mysqli_connection,$query);
        return $result;
    }
    
// 21.) [convert_statement] this converts statement from array to normal sql statement format
private function convert_statement($array_statement)
    {
            $r=array();
            foreach($array_statement as $b=>$c):
            $_1[]='`'.$b.'`';
            $_2[]="'".$c."'";;
            $_3[]='`'.$b.'`='."'".$c."'";
            endforeach;
            $r['fields']=implode(',',$_1);
            $r['values']=implode(',',$_2);
            $r['set']=implode(',',$_3);
            $r['or']=implode(' OR ',$_3);
            if(count($_3)>1):
            $end=end($_3);
            $r['where']=str_replace(','.$end,'',$r['set']);
            $r['where'].=' AND '.$end;
            else: $r['where']=$r['set'];
            endif;
            return $r;
    }
    
}
