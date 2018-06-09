import React, {ListView,DataSource,Component} from 'react';
import axios from 'axios';
import { Link } from 'react-router';
import VirtualList from 'react-tiny-virtual-list';
import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider'
import FontIcon from 'material-ui/FontIcon';

class DisplayCity extends Component {
  constructor(props) {
       super(props);
     
       this.state = {
                      value: '', items: [] , all : []              
                };
     }
     componentDidMount(){
       axios.get('api/city?lang=en')
       .then(response => {
         this.setState({ items:response.data.data,all: response.data });
       })
       .catch(function (error) {
         console.log(error);
       })       
     }     
    _addMore(){
      if(this.state.all){
        if(this.state.all.links.next){
          axios.get(this.state.all.links.next+'&lang=en')
           .then(response => {
             this.setState({ 
              items: this.state.items.concat(response.data.data),
              all: response.data 
            });
           })
           .catch(function (error) {
             console.log(error);
           })  
        }
      }
    }
  
  render(){
    //console.log(this.state.items);
    const data = this.state.items;
    return (     
      <div>
        <h1>Location</h1>
         <VirtualList
            width='100%'
            height={600}
            itemCount={data.length}
            itemSize={50}
            onItemsRendered={()=>this._addMore()}
            renderItem={({index, style}) =>
              <div key={index} style={style}>
                <a href={`/content?city_id=${data[index].id}&lang=en`}> <h4> {data[index].attributes.name}</h4></a>
              </div>
            }
          />       
    </div>
    )
  }
}
export default DisplayCity;