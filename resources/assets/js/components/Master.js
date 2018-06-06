import React, {Component} from 'react';
import { Router, Route, Link } from 'react-router';
import getRouteHandlerBaseUrl from '../helpers/get-route-handler-base-url';
import Sideleft from './layout/sideleft';

class Master extends Component {

   constructor(props){
    super(props);
   }
   
  componentWillMount() {
		this._baseUrl = getRouteHandlerBaseUrl(this.props)
	}

  render(){
    return (
      <div className="container">
        <nav className="navbar navbar-default">
          <div className="container-fluid">
            <div className="navbar-header">
              <a className="navbar-brand" href="#">B-Site Solution</a>
            </div>
            <ul className="nav navbar-nav">
              <li className="active"><Link to={this._baseUrl+"/"}>Home</Link></li>
              <li><Link to={this._baseUrl+"/display-item"}>Items</Link></li>
              <li><a href="#">Page 2</a></li>
              <li><a href="#">Page 3</a></li>
            </ul>
          </div>
      </nav>
        <div  className="row">
          <div className="col-md-3">
            <Sideleft />
          </div>
          <div className="col-md-9">
              {this.props.children}
          </div>
        </div>
      </div>
    )
  }
}
export default Master;