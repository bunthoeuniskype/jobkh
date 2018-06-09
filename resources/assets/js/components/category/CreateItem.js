import React, {Component} from 'react';
import { browserHistory } from 'react-router'
import baseUrl from '../../helpers/baseUrl';

class CreateItem extends Component {

    constructor(props){
    super(props);
    this.state = {productName: '', productPrice: ''};

    this.handleChange1 = this.handleChange1.bind(this);
    this.handleChange2 = this.handleChange2.bind(this);
    this.handleSubmit = this.handleSubmit.bind(this);
  }
  
  componentWillMount() {
		this.baseUrl = baseUrl(this.props)
	}

  handleChange1(e){
    this.setState({
      productName: e.target.value
    })
  }
  handleChange2(e){
    this.setState({
      productPrice: e.target.value
    })
  }
  handleSubmit(e){
    e.preventDefault();
    const products = {
      name: this.state.productName,
      price: this.state.productPrice
    }
    let uri = this.baseUrl+"/items";
    axios.post(uri, products).then((response) => {
      browserHistory.push('/display-item');
    });
  }


    render() {
      return (
      <div>
        <h1>Create An Item</h1>
        <form>
          <div className="row">
            <div className="col-md-6">
              <div className="form-group">
                <label>Item Name:</label>
                <input type="text" className="form-control"  onChange={this.handleChange1}/>
              </div>
            </div>
            </div>
            <div className="row">
              <div className="col-md-6">
                <div className="form-group">
                  <label>Item Price:</label>
                  <input type="text" className="form-control col-md-6"  onChange={this.handleChange2}/>
                </div>
              </div>
            </div><br />
            <div className="form-group">
              <button className="btn btn-primary" onClick={this.handleSubmit}>Add Item</button>
            </div>
        </form>
  </div>
      )
    }
}
export default CreateItem;