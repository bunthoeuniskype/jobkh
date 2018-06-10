import React, {Component} from 'react';
import axios from 'axios';
import { Link } from 'react-router';
import VirtualList from 'react-tiny-virtual-list';
import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider'
import FontIcon from 'material-ui/FontIcon';
import ReactDOM from 'react-dom';
import ListView from 'rmc-list-view';

class DisplayContent extends Component {
   constructor(props) {
       super(props);

             const dataSource = new ListView.DataSource({
                rowHasChanged: (row1, row2) => row1 !== row2,
              });

            this.state = {
                      dataSource,
                      isLoading: true,
                      items: [],
                      all : [],   
                      isLoadingText: 'Loading....'      
                };
        this.handleScroll = this.handleScroll.bind(this);        
     }


     componentDidMount(){
          
          let params = location.search.replace('?','&');
          if(params==''){
            params = '&lang=en';
          }
          document.body.style.overflowY =
          navigator.userAgent.match(/Android|iPhone|iPad|iPod/i) ? 'hidden' : 'auto';
        // you can scroll to the specified position
        setTimeout(() => this.lv.scrollTo(0, 50), 800);

        // simulate initial Ajax
        setTimeout(() => {
          axios.get('api/content?sort_by=publish_date'+params)
           .then(response => {
             this.setState({ 
                dataSource: this.state.dataSource.cloneWithRows(response.data.data),
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

    _addMore(){
       let params = location.search.replace('?','&');
          if(params==''){
            params = '&lang=en';
          }

      if(this.state.all){
        if(this.state.all.links.next){
          this.setState({ isLoading: true,isLoadingText: 'Loading....' });
          axios.get(this.state.all.links.next+'&sort_by=publish_date'+params)
           .then(response => {
             let data = this.state.items;
             let newData = response.data.data;
             newData.map((item) => data.push(item));
             this.setState({ 
                dataSource: this.state.dataSource.cloneWithRows(this.state.items),
                isLoading: false,
                //items:response.data.data,
                all: response.data ,
                isLoadingText: 'Read More' 
             });
           })
           .catch(function (error) {
             console.log(error);
           })  
        }else{
          this.setState({ isLoadingText: 'No Record' });
        }
      }
    }

    handleScroll(event){
       setTimeout(() => {
         this._addMore();
      }, 1000);
    }

  _checkNull(val){

    if(val !== null){
      return true;
    }
    return false;

  }
    
  render(){    

       return (<div style={{ border: '1px solid #ccc', margin: 10 }}>
                <h1 style={{ borderBottom: '1px solid #ccc', margin: 10 }}> Jobs </h1>
                <ListView
                  ref={el => this.lv = el}   
                  dataSource={this.state.dataSource}
                  style={{ height: 550 }} 
                  renderRow={rowData => <div style={{ padding: 16 }}>
                    <a href={`/content/detail?id=${rowData.id}&lang=en`} target="_blank"><h4>{rowData.attributes.title}</h4></a>
                    <h5> { rowData.relationships.city ? 'Location : '+ rowData.relationships.city.attributes.name : null }, Close date : {rowData.attributes.close_date} </h5>
                  </div> }
                  renderFooter={() => (<div>
                    <button  style={{ padding: 10, width:'100%', background: '#5b95ff',color:'#fff',fontSize:16 }} onClick={this.handleScroll}>{this.state.isLoadingText}</button></div>)}                  
                  onEndReachedThreshold={5}
                  pageSize={5}
                />
              </div>);
       }
  
}
export default DisplayContent;