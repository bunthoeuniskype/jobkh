import React, { Component } from 'react';
import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider'
import Paper from 'material-ui/Paper';
import Menu from 'material-ui/Menu';
import MenuItem from 'material-ui/MenuItem';
import RemoveRedEye from 'material-ui/svg-icons/image/remove-red-eye';
import PersonAdd from 'material-ui/svg-icons/social/person-add';
import ContentLink from 'material-ui/svg-icons/content/link';
import Divider from 'material-ui/Divider';
import ContentCopy from 'material-ui/svg-icons/content/content-copy';
import Download from 'material-ui/svg-icons/file/file-download';
import Delete from 'material-ui/svg-icons/action/delete';
import FontIcon from 'material-ui/FontIcon';
import injectTapEventPlugin from "react-tap-event-plugin";
injectTapEventPlugin();

export default class Sideleft extends Component {

      render () {     
                 
    const style = {
        paper: {
            display: 'inline-block',
            float: 'left',
            margin: '16px 32px 16px 0',
        },
        rightIcon: {
            textAlign: 'center',
            lineHeight: '24px',
        },
        };

    return (    
      <MuiThemeProvider>  
             <div>     
            <Paper style={style.paper}>
            <a href="https://play.google.com/store/apps/details?id=com.appcalendar" title="Calendar Kh" target="_blank"> 
               <img src="https://lh3.googleusercontent.com/e1NrfqK2uu_KNnCRIRWP9y3Uyx3cqUt29AfzXtidnxfhuctigbAp9uDzU3fYxh1p5Bp7=w720-h310-rw"/>
            </a>           
            </Paper>            
           </div>      
      </MuiThemeProvider>  
     
      );   
        
    }    
}
