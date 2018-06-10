'use strict';
import React, {Component} from 'react';
import axios from 'axios';
import { Link } from 'react-router';
import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider'
import FontIcon from 'material-ui/FontIcon';
import ReactDOM from 'react-dom';
import PropTypes from 'prop-types';
import Card, { CardActions, CardContent, CardMedia } from 'material-ui/Card';
import Divider from 'material-ui/Divider';
import Paper from 'material-ui/Paper';
import Button from 'material-ui/Paper';
//const translate = require('google-translate-api');

const styles = {
  card: {
    padding:15
  },
  bullet: {
    display: 'inline-block',
    margin: '0 2px',
    transform: 'scale(0.8)',
  },
  title: {
    marginBottom: 16,
    fontSize: 14,
  },
  pos: {
    marginBottom: 12,
  },
  titleDetail:{
    color:'darkblue',   
    paddingLeft:10,
    textUnderline:1,
    textDecorationLine: "underline",
    textDecorationStyle: "solid",
    textDecorationColor: "grey",
  }

};

class DisplayContentDetail extends Component {
   constructor(props) {
       super(props);             
      
            this.state = {                      
                      isLoading: true,
                      items: [],
                      all : [],   
                      isLoadingText: 'Loading....'      
                };
             
     }


     componentDidMount(){
          
          let params = location.search;
          if(params==''){
            params = '?lang=en';
          }
          document.body.style.overflowY =
          navigator.userAgent.match(/Android|iPhone|iPad|iPod/i) ? 'hidden' : 'auto';
        
        // simulate initial Ajax
        setTimeout(() => {
          axios.get('/api/content/detail'+params)
           .then(response => {
             this.setState({               
                items:response.data.data,
                isLoading: false,
                all: response.data,
                isLoadingText: 'Read More' 
              });
           })
           .catch(function (error) {
             console.log(error);
           })      
        }, 600);      
     }     

   
  _checkNull(val){

    if(val !== null){
      return true;
    }
    return false;

  }
  
  createMarkup(data) {
  return {__html: data };
  }

  _translate(txt){

    translate('I spea Dutch!', {from: 'en', to: 'nl'}).then(res => {
        console.log(res.text);
        //=> Ik spreek Nederlands!
        console.log(res.from.text.autoCorrected);
        //=> true
        console.log(res.from.text.value);
        //=> I [speak] Dutch!
        console.log(res.from.text.didYouMean);
        //=> false
    }).catch(err => {
        console.error(err);
    });

  }
  _renderView(){
    if(this.state.items.length>0){
      const data = this.state.items[0];
      return (
                <MuiThemeProvider> 
                     <Paper style={styles.paper}>
                       <Card style={styles.card}>                        
                          <h3 style={styles.titleDetail}>{data.attributes.title}</h3>
                          <Divider/> 
                          <h4 style={styles.titleDetail}>Job Specification</h4>                     
                          <CardActions>
                            <h5>Hiring : {data.attributes.hiring}</h5>
                            <h5>Experience : {data.attributes.experience}</h5>
                            <h5>Age : {data.attributes.age}</h5>
                            <h5>Salary : {data.attributes.salary}</h5>
                            <h5>Term : {data.attributes.term}</h5>                           
                            <h5>Position : {data.attributes.function}</h5>
                            <h5>Language :  <span dangerouslySetInnerHTML={this.createMarkup(data.attributes.language)}></span></h5>                           
                            <h5>Qualification : {data.attributes.qualification}</h5>
                            <h5>Location : {data.relationships.city?data.relationships.city.attributes.name:''}</h5>
                            <h5>Close date : {data.attributes.close_date}</h5>
                          </CardActions> 
                          <Divider/> 
                          <h4 style={styles.titleDetail}>Job Description</h4>                     
                          <CardActions>
                            <p dangerouslySetInnerHTML={this.createMarkup(data.attributes.description)}></p>
                          </CardActions>
                          <Divider/>  
                          <h4 style={styles.titleDetail}>Job Requirement</h4>    
                          <CardActions>
                            <p dangerouslySetInnerHTML={this.createMarkup(data.attributes.job_requirement)}></p>
                          </CardActions>
                          <Divider/>  
                          <h4 style={styles.titleDetail}>Contact</h4>    
                          <CardActions>
                            <h5>Company : {data.attributes.company}</h5>
                            <h5>Contact : {data.attributes.contact}</h5>
                            <h5>Phone : {data.attributes.phone}</h5>
                            <h5>Email :{data.attributes.email} </h5>
                            <h5>Website : {data.attributes.website}</h5>
                            <h5>Address : {data.attributes.address}</h5>
                          </CardActions>
                        </Card>
                       </Paper> 
                </MuiThemeProvider>
        );
    }
    return <div style={styles.titleDetail}><h3> Data Loading </h3></div>
  }

  render(){         
       return (<div style={{ border: '1px solid #ccc', margin: 10 }}>
                <h1 style={{ borderBottom: '1px solid #ccc', margin: 10 }}> Jobs Details</h1>
                     {this._renderView()} 
                 </div>);
       }
  
}
export default DisplayContentDetail;