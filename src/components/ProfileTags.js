import * as React from 'react';
import Container from 'react-bootstrap/Container';
import Row from 'react-bootstrap/Row';
import Col from 'react-bootstrap/Col';
import Badge from 'react-bootstrap/Badge';
import Button from 'react-bootstrap/Button';

export default class ProfileTags extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            tags: this.props.tags
        }
        if(!Array.isArray(this.state.tags)){
          this.state.tags = []
        }
        console.log("ProfileTags: ", this.state.tags)
    }

    render() {
      const { tags } = this.state;
        return (
            <Container>
            <Row>
            <Col>
               {tags.map((tag, index) => (
                            <Badge pill key={index}>
                             {tag.name}
                            </Badge> 
                       ))} 
             </Col> 
            </Row> 
            </Container>

        )
    }
}