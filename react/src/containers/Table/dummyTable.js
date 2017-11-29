// @flow
const dummyTable = {
  votes: [
    {
      rowId: "1",
      votes: "2000",
      upvoted: false
    },
    {
      rowId: "2",
      votes: "2000",
      upvoted: false
    },
    {
      rowId: "3",
      votes: "2000",
      upvoted: false
    },
    {
      rowId: "4",
      votes: "2000",
      upvoted: false
    },
    {
      rowId: "5",
      votes: "2000",
      upvoted: false
    },
    {
      rowId: "6",
      votes: "2000",
      upvoted: false
    },
    {
      rowId: "7",
      votes: "2000",
      upvoted: false
    },
    {
      rowId: "8",
      votes: "2000",
      upvoted: false
    },
    {
      rowId: "9",
      votes: "2000",
      upvoted: false
    },
    {
      rowId: "10",
      votes: "2000",
      upvoted: false
    },
    {
      rowId: "11",
      votes: "2000",
      upvoted: false
    },
    {
      rowId: "12",
      votes: "2000",
      upvoted: false
    },
    {
      rowId: "13",
      votes: "2000",
      upvoted: false
    },
    {
      rowId: "14",
      votes: "2000",
      upvoted: false
    },
    {
      rowId: "15",
      votes: "2000",
      upvoted: false
    },
    {
      rowId: "16",
      votes: "2000",
      upvoted: false
    },
    {
      rowId: "17",
      votes: "2000",
      upvoted: false
    }
  ],
  columns: [
    {
      id: "1",
      title: "Name"
    },
    {
      id: "2",
      title: "Functionality"
    },
    {
      id: "3",
      title: "URL"
    },
    {
      id: "4",
      title: "Price"
    }
  ],
  rows: [
    {
      id: "1",
      content: [
        {
          id: "1",
          content: "Talkus",
          link: null
        },
        {
          id: "2",
          content:
            "Centralize all your customer feedback (livechat, email, sms, twitter, facebook) in one place, Slack",
          link: null
        },
        {
          id: "3",
          content: "http://talkus.io",
          link: null
        },
        {
          id: "4",
          content: "$48/mo unlimited agents",
          link: null
        }
      ]
    },
    {
      id: "2",
      content: [
        {
          id: "5",
          content: "UserTest.io",
          link: null
        },
        {
          id: "6",
          content:
            "Video feedback of your users voicing their thoughts and opions as they complete tasks.",
          link: null
        },
        {
          id: "7",
          content: "https://usertest.io",
          link: null
        },
        {
          id: "8",
          content: "$10 per Your Own Tester, $23 per Qualified Website Tester",
          link: null
        }
      ]
    },
    {
      id: "3",
      content: [
        {
          id: "9",
          content: "UserTesting",
          link: null
        },
        {
          id: "10",
          content: "Video feedback on your website or app",
          link: null
        },
        {
          id: "11",
          content: "https://www.usertesting.com",
          link: null
        },
        {
          id: "12",
          content: "1 free 5min review, $49 per review thereafter",
          link: null
        }
      ]
    },
    {
      id: "4",
      content: [
        {
          id: "13",
          content: "Temper",
          link: null
        },
        {
          id: "14",
          content:
            "Temper measures how your customers feel about your business so you know what to improve",
          link: null
        },
        {
          id: "15",
          content: "https://www.temper.io/",
          link: null
        },
        {
          id: "16",
          content: "$12/mo.",
          link: null
        }
      ]
    },
    {
      id: "5",
      content: [
        {
          id: "17",
          content: "LiveChat",
          link: null
        },
        {
          id: "18",
          content:
            "Premium live chat and help desk software for websites and apps",
          link: null
        },
        {
          id: "19",
          content: "https://www.livechatinc.com",
          link: null
        },
        {
          id: "20",
          content: "$16/mo",
          link: null
        }
      ]
    },
    {
      id: "6",
      content: [
        {
          id: "21",
          content: "Olark",
          link: null
        },
        {
          id: "22",
          content:
            "Experience the easiest way to boost your sales, help solve issues and understand your customers.",
          link: null
        },
        {
          id: "23",
          content: "https://www.olark.com/",
          link: null
        },
        {
          id: "24",
          content: "15$/mo.",
          link: null
        }
      ]
    },
    {
      id: "7",
      content: [
        {
          id: "25",
          content: "Intercom",
          link: null
        },
        {
          id: "26",
          content:
            "Intercom is one place for your entire business to see and talk to customers.",
          link: null
        },
        {
          id: "27",
          content: "https://www.intercom.io/",
          link: null
        },
        {
          id: "28",
          content: "https://www.intercom.io/pricing",
          link: null
        }
      ]
    },
    {
      id: "8",
      content: [
        {
          id: "29",
          content: "Qualaroo",
          link: null
        },
        {
          id: "30",
          content:
            "Get Voice of Customer Insights that help Your Business Grow.",
          link: null
        },
        {
          id: "31",
          content: "https://qualaroo.com/",
          link: null
        },
        {
          id: "32",
          content: "63$/mo.",
          link: null
        }
      ]
    },
    {
      id: "9",
      content: [
        {
          id: "33",
          content: "Ottspott",
          link: null
        },
        {
          id: "34",
          content: "Phone system for Slack marketing, sales & support teams.",
          link: null
        },
        {
          id: "35",
          content: "http://ottspott.co/",
          link: null
        },
        {
          id: "36",
          content: "Startup Pack: €49/month including 3 users",
          link: null
        }
      ]
    },
    {
      id: "10",
      content: [
        {
          id: "37",
          content: "UsabilityTools",
          link: null
        },
        {
          id: "38",
          content:
            "Optimize websites for better user experience and higher conversion",
          link: null
        },
        {
          id: "39",
          content: "http://usabilitytools.com/",
          link: null
        },
        {
          id: "40",
          content: "Differs",
          link: null
        }
      ]
    },
    {
      id: "11",
      content: [
        {
          id: "41",
          content: "Typeform",
          link: null
        },
        {
          id: "42",
          content:
            "Typeform specializes in beautiful, intuitive survey experiences",
          link: null
        },
        {
          id: "43",
          content: "https://www.typeform.com/",
          link: null
        },
        {
          id: "44",
          content: "Free",
          link: null
        }
      ]
    },
    {
      id: "12",
      content: [
        {
          id: "45",
          content: "Tawk",
          link: null
        },
        {
          id: "46",
          content: "Totally free live chat :)",
          link: null
        },
        {
          id: "47",
          content: "https://tawk.to",
          link: null
        },
        {
          id: "48",
          content: "Free",
          link: null
        }
      ]
    },
    {
      id: "13",
      content: [
        {
          id: "49",
          content: "Trustbadge",
          link: null
        },
        {
          id: "50",
          content: "Grow your Business & Show that your customers love you",
          link: null
        },
        {
          id: "51",
          content: "http://www.trustbadge.com/",
          link: null
        },
        {
          id: "52",
          content: "Free",
          link: null
        }
      ]
    },
    {
      id: "14",
      content: [
        {
          id: "53",
          content: "Hotline",
          link: null
        },
        {
          id: "54",
          content:
            "In app support chat, user engagement and FAQs for Mobile apps",
          link: null
        },
        {
          id: "55",
          content: "https://www.hotline.io",
          link: null
        },
        {
          id: "56",
          content: "Free Upto 25k MAU",
          link: null
        }
      ]
    },
    {
      id: "15",
      content: [
        {
          id: "57",
          content: "Crisp",
          link: null
        },
        {
          id: "58",
          content: "Simple and affordable live chat for your website.",
          link: null
        },
        {
          id: "59",
          content: "https://crisp.chat/",
          link: null
        },
        {
          id: "60",
          content: "Free, $25/m, $95/m",
          link: null
        }
      ]
    },
    {
      id: "16",
      content: [
        {
          id: "61",
          content: "Vero",
          link: null
        },
        {
          id: "62",
          content: "Automated emails based on user behaviour",
          link: null
        },
        {
          id: "63",
          content: "http://www.getvero.com/",
          link: null
        },
        {
          id: "64",
          content: "From $99/m",
          link: null
        }
      ]
    },
    {
      id: "17",
      content: [
        {
          id: "65",
          content: "elevio",
          link: null
        },
        {
          id: "66",
          content:
            "Display support content in-app, and get implicit and explicit feedback on the content, in context",
          link: null
        },
        {
          id: "67",
          content: "https://elev.io",
          link: null
        },
        {
          id: "68",
          content: "Starting at $49/m",
          link: null
        }
      ]
    }
  ]
};

export default dummyTable;
