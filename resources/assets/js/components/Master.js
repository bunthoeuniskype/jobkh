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
              <Link className="navbar-brand"  to={this._baseUrl+"/"}>Job Finder</Link>
            </div>
            <ul className="nav navbar-nav">
              <li className="active"><Link to={this._baseUrl+"/"}>Home</Link></li>
              <li><Link to={this._baseUrl+"/job"}>Jobs</Link></li>
              <li><Link to={this._baseUrl+"/location"}>Location</Link></li>
              <li><Link to={this._baseUrl+"/category"}>Category</Link></li>
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