import { TABLE_RECEIVED } from './actions';

// TODO: flow typing
// TODO: tests

const initialState = {
  data: [
    [2000, 'Talkus', 'Centralize all your customer feedback (livechat, email, sms, twitter, facebook) in one place, Slack', 'http://talkus.io', '$48/mo unlimited agents'],
    [1998, 'UserTest.io', 'Video feedback of your users voicing their thoughts and opions as they complete tasks.', 'https://usertest.io', '$10 per Your Own Tester, $23 per Qualified Website Tester'],
    [1990, 'UserTesting', 'Video feedback on your website or app', 'https://www.usertesting.com', '1 free 5min review, $49 per review thereafter'],
    [1988, 'Temper', 'Temper measures how your customers feel about your business so you know what to improve', 'https://www.temper.io/', '$12/mo.'],
    [1802, 'LiveChat', 'Premium live chat and help desk software for websites and apps', 'https://www.livechatinc.com', '$16/mo'],
    [1791, 'Olark', 'Experience the easiest way to boost your sales, help solve issues and understand your customers.', 'https://www.olark.com/', '15$/mo.'],
    [1700, 'Intercom', 'Intercom is one place for your entire business to see and talk to customers.', 'https://www.intercom.io/', 'https://www.intercom.io/pricing'],
    [1697, 'Qualaroo', 'Get Voice of Customer Insights that help Your Business Grow.', 'https://qualaroo.com/', '63$/mo.'],
    [1696, 'Ottspott', 'Phone system for Slack marketing, sales & support teams.', 'http://ottspott.co/', 'Startup Pack: €49/month including 3 users'],
    [1690, 'UsabilityTools', 'Optimize websites for better user experience and higher conversion', 'http://usabilitytools.com/', 'Differs'],
    [1450, 'Typeform', 'Typeform specializes in beautiful, intuitive survey experiences', 'https://www.typeform.com/', 'Free'],
    [1349, 'Tawk', 'Totally free live chat :)', 'https://tawk.to', 'Free'],
    [1298, 'Trustbadge', 'Grow your Business & Show that your customers love you', 'http://www.trustbadge.com/', 'Free'],
    [1100, 'Hotline', 'In app support chat, user engagement and FAQs for Mobile apps', 'https://www.hotline.io', 'Free Upto 25k MAU'],
    [1000, 'Crisp', 'Simple and affordable live chat for your website.', 'https://crisp.chat/', 'Free, $25/m, $95/m'],
    [996, 'Vero', 'Automated emails based on user behaviour', 'http://www.getvero.com/', 'From $99/m'],
    [878, 'elevio', 'Display support content in-app, and get implicit and explicit feedback on the content, in context', 'https://elev.io', 'Starting at $49/m']
  ],
};

export default (state = initialState, action) => {
  switch (action.type) {
    case TABLE_RECEIVED:
      return {
        ...state,
        table: action.payload.data,
      };
    default:
      return state;
  }
}
