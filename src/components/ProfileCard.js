import * as React from 'react';
import Container from 'react-bootstrap/Container';
import Row from 'react-bootstrap/Row';
import Col from 'react-bootstrap/Col';

import Card from 'react-bootstrap/Card';
import CardImg from 'react-bootstrap/CardImg';
import Button from 'react-bootstrap/Button';

import ProfileTags from './ProfileTags.js';



let image = ""


export default class ProfileCard extends React.Component {

    constructor(props){
        super(props);
        if(!this.props.profile.hasOwnProperty("x_featured_media_medium")){
            this.props.profile.x_featured_media_medium = "https://ivfsf.narramur.de/wp-content/uploads/2022/03/noimage.png"
            } 
        this.state = {
            profile: this.props.profile,
            tags: this.props.tags
        }
    }


    componentWillMount() {
       //console.log(this.state.profile)
//       console.log("IMAGE: ", this.state.data.x_featured_media_medium)
//       console.log(this.state.tags)

const { profile, tags } = this.state;
if(!Array.isArray(profile.profile_tags)){
  this.state.profile.profile_tags = []
}
let obj={};
for (let i = 0; i < this.state.profile.profile_tags.length; i++) {
  for (let j = 0; j < tags.length; j++) {
    if(tags[j]["id"] === this.state.profile.profile_tags[i]){
      obj = tags[j];
    }
  }
  this.state.profile.profile_tags[i]= obj; 
  
} 

      }

    render() {
        const { profile, tags } = this.state;
       return (
      
        <Card style={{ width: '36 rem' }}>
              <Card.Body>

            <Container>
  <Row>
    <Col>
    <img className="ivfsf" alt="Card image cap" 
      src={profile.x_featured_media_medium}
    />
    </Col>
    <Col>
    <Card.Title>{profile.title.rendered}</Card.Title>
    <ProfileTags tags = {profile.profile_tags}/>
    </Col>
  </Row>
  <Row>
      <Col>
&nbsp;
      </Col>
  </Row>
  <Row>
      <Col>
      <Card.Text>
    {profile.vita}
    </Card.Text>
      </Col>
  </Row>
  <Row>
      <Col>
&nbsp;
      </Col>
  </Row>
  <Row>
      <Col>
      <Card.Text>
      <Button variant="primary" href={profile.link} >Zum Profil</Button>
    </Card.Text>
      </Col>
  </Row>

  </Container>
    
  </Card.Body>
</Card>
       )
    }

}

